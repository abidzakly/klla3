<?php

namespace App\Http\Controllers;

use App\Models\PhotoEvent;
use App\Models\PhotoEventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Response;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PhotoEventController extends Controller
{
    public function index(Request $request, PhotoEventType $photoEventType)
    {
        $branch = Branch::where('branch_name', $request->branch)->first() ?? Branch::all()->first();
        $photoEvents = PhotoEvent::where('photo_event_type_id', $photoEventType->id_photo_event_type)->where('branch_id', $branch->id_branch)->count();
        return view('photo_event.index', ['photoEventType' => $photoEventType, 'branch' => $branch, 'photoEvents' => $photoEvents]);
    }

    public function getData(Request $request)
    {
        $data = PhotoEvent::where('photo_event_type_id', $request->photo_event_type_id)
            ->where('branch_id', $request->branch_id);

        $listSearch = ['file_path'];
        $data = self::filterDatatable($data, $listSearch);

        $startDate = Carbon::parse($request->start_date)->startOfDay(); // 2025-04-19 00:00:00
        $endDate = Carbon::parse($request->end_date)->endOfDay();       // 2025-04-19 23:59:59

        if ($request->start_date && $request->end_date) {
            $data->whereBetween('photo_event_date', [$startDate, $endDate]);
        } elseif ($request->start_date) {
            $data = $data->where('photo_event_date', '>=', $startDate);
        } elseif ($request->end_date) {
            $data = $data->where('photo_event_date', '<=', $endDate);
        }

        $data = $data->get()->chunk(5);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('photos', function ($rows) {
                $html = '<div class="grid grid-cols-1 justify-center m-8 w-full gap-8 lg:grid-cols-4 md:grid-cols-3 relative sm:grid-cols-2 xl:grid-cols-5">';
                foreach ($rows as $row) {
                    $html .= view('photo_event.partials.photo', compact('row'))->render();
                }
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['photos'])
            ->make(true);
    }

    private static function filterDatatable($query, $searchColumns)
    {
        $searchValue = request('search.value');
        if ($searchValue) {
            $query->where(function ($query) use ($searchColumns, $searchValue) {
                foreach ($searchColumns as $column) {
                    $query->orWhere($column, 'like', '%' . $searchValue . '%');
                }
            });
        }
        return $query;
    }


    public function store(Request $request, PhotoEventType $photoEventType)
    {
        $request->validate([
            'branch_id'                 => 'required|ulid',
            'photo_event_type_id'       => 'required|ulid',

            'photo_event_file_name'     => 'required|array',
            'photo_event_file_name.*'   => 'required|string|max:255',

            'photo_event_name'          => 'required|array',
            'photo_event_name.*'        => 'required|string|max:255',

            'photo_event_location'      => 'required|array',
            'photo_event_location.*'    => 'required|string|max:255',

            'photo_event_caption'       => 'required|array',
            'photo_event_caption.*'     => 'required|string|max:500',

            'photo_event_date'          => 'required|array',
            'photo_event_date.*'        => 'required|date',

            'files'                     => 'required|array',
            'files.*'                   => 'required|file|mimes:jpg,jpeg,png,svg|max:10240',
        ], [
            'branch_id.required' => 'Cabang wajib dipilih.',
            'branch_id.ulid' => 'Format cabang tidak valid.',

            'photo_event_type_id.required' => 'Jenis event wajib dipilih.',
            'photo_event_type_id.ulid' => 'Format jenis event tidak valid.',

            'photo_event_file_name.required' => 'Nama file wajib diisi.',
            'photo_event_file_name.*.required' => 'Nama file wajib diisi.',
            'photo_event_file_name.*.string' => 'Nama file harus berupa teks.',
            'photo_event_file_name.*.max' => 'Nama file maksimal 255 karakter.',

            'photo_event_name.required' => 'Nama event wajib diisi.',
            'photo_event_name.*.required' => 'Nama event wajib diisi.',
            'photo_event_name.*.string' => 'Nama event harus berupa teks.',
            'photo_event_name.*.max' => 'Nama event maksimal 255 karakter.',

            'photo_event_location.required' => 'Lokasi event wajib diisi.',
            'photo_event_location.*.required' => 'Lokasi event wajib diisi.',
            'photo_event_location.*.string' => 'Lokasi event harus berupa teks.',
            'photo_event_location.*.max' => 'Lokasi event maksimal 255 karakter.',

            'photo_event_caption.required' => 'Caption wajib diisi.',
            'photo_event_caption.*.required' => 'Caption wajib diisi.',
            'photo_event_caption.*.string' => 'Caption harus berupa teks.',
            'photo_event_caption.*.max' => 'Caption maksimal 500 karakter.',

            'photo_event_date.required' => 'Tanggal event wajib diisi.',
            'photo_event_date.*.required' => 'Tanggal event wajib diisi.',
            'photo_event_date.*.date' => 'Format tanggal tidak valid.',

            'files.required' => 'File wajib diunggah.',
            'files.*.required' => 'File wajib diunggah.',
            'files.*.file' => 'File harus berupa berkas.',
            'files.*.mimes' => 'File harus berupa jpg, jpeg, png, svg atau pdf.',
            'files.*.max' => 'Ukuran maksimal file adalah 10MB.',
        ]);


        DB::beginTransaction();

        try {
            $branchName = strtolower(str_replace(' ', '-', Branch::findOrFail($request->branch_id)->branch_name));
            foreach ($request->file('files') as $index => $file) {
                $jenisEvent = strtolower(str_replace(' ', '-', $photoEventType->photo_event_type_name));
                $fileNameOriginal = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $fileName = $request->photo_event_file_name[$index] . '.' . $ext;
                $newPath = "photo-event/{$jenisEvent}/{$branchName}/{$fileName}";

                $counter = 1;
                while (Storage::exists($newPath)) {
                    $fileName = "{$fileNameOriginal}($counter).{$ext}";
                    $newPath = "photo-event/{$jenisEvent}/{$branchName}/{$fileName}";
                    $counter++;
                }

                $path = $file->storeAs("photo-event/{$jenisEvent}/{$branchName}/" . $request->photo_event_date[$index], $fileName);

                PhotoEvent::create([
                    'photo_event_type_id'    => $request->photo_event_type_id,
                    'branch_id'              => $request->branch_id,
                    'file_path'              => $path,
                    'photo_event_name'       => $request->photo_event_name[$index],
                    'photo_event_location'   => $request->photo_event_location[$index],
                    'photo_event_caption'    => $request->photo_event_caption[$index], // field baru
                    'photo_event_date'       => $request->photo_event_date[$index],    // field baru
                ]);
            }


                DB::commit();
                return Response::success(null, 'Upload berhasil');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return Response::errorCatch($e, 'Upload gagal');
        }
    }

    public function show(PhotoEvent $photoEvent)
    {
        $data = $photoEvent->toArray();
        $data['file_url'] = $photoEvent->file_path ? asset('storage/' . $photoEvent->file_path) : '';
        $data['photo_event_file_name'] = pathinfo($photoEvent->file_path, PATHINFO_FILENAME);
        $data['photo_event_date'] = Carbon::parse($photoEvent->photo_event_date)->format('Y-m-d');
        $data['photo_event_date_text'] = Carbon::parse($photoEvent->photo_event_date)->translatedFormat('l, d F Y');
        return response()->json(['data' => $data]);
    }

    public function update(Request $request, PhotoEvent $photoEvent)
    {
        $rules = [
            'photo_event_file_name'   => 'required|string|max:255',
            'photo_event_name'        => 'required|string|max:255',
            'photo_event_location'    => 'required|string|max:255',
            'photo_event_caption'     => 'required|string|max:500',
            'photo_event_date'        => 'required|date',
            'file'                    => 'nullable|file|mimes:jpg,jpeg,png,svg|max:10240',
        ];
        $messages = [
            'photo_event_file_name.required' => 'Nama file wajib diisi.',
            'photo_event_name.required' => 'Nama event wajib diisi.',
            'photo_event_location.required' => 'Lokasi event wajib diisi.',
            'photo_event_caption.required' => 'Caption wajib diisi.',
            'photo_event_date.required' => 'Tanggal event wajib diisi.',
            'file.mimes' => 'File harus berupa jpg, jpeg, png, svg.',
            'file.max' => 'Ukuran maksimal file adalah 10MB.',
        ];
        $validated = $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            $updateData = [
                'photo_event_name' => $request->photo_event_name,
                'photo_event_location' => $request->photo_event_location,
                'photo_event_caption' => $request->photo_event_caption,
                'photo_event_date' => $request->photo_event_date,
            ];

            // Rename file jika nama file berubah
            $oldPath = $photoEvent->file_path;
            $ext = pathinfo($oldPath, PATHINFO_EXTENSION);
            $dir = dirname($oldPath);
            $newFileName = $request->photo_event_file_name . '.' . $ext;
            $newPath = $dir . '/' . $newFileName;

            if ($request->photo_event_file_name !== pathinfo($oldPath, PATHINFO_FILENAME)) {
                $counter = 1;
                while (Storage::exists($newPath)) {
                    $newFileName = $request->photo_event_file_name . "($counter)." . $ext;
                    $newPath = $dir . '/' . $newFileName;
                    $counter++;
                }
                if (Storage::exists($oldPath)) {
                    Storage::move($oldPath, $newPath);
                }
                $updateData['file_path'] = $newPath;
            }

            // Jika upload file baru (replace)
            if ($request->hasFile('file')) {
                if (Storage::exists($photoEvent->file_path)) {
                    Storage::delete($photoEvent->file_path);
                }
                $file = $request->file('file');
                $file->storeAs($dir, $newFileName);
                $updateData['file_path'] = $dir . '/' . $newFileName;
            }

            $photoEvent->update($updateData);

            DB::commit();
            return Response::success(null, 'Update berhasil');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e, 'Update gagal');
        }
    }

    public function rename(Request $request, PhotoEvent $photoEvent)
    {
        //  test error
        // return Response::error(null, 'Error');
        $request->validate([
            'file_name' => 'required|string',
        ]);

        $pathInfo = pathinfo($photoEvent->file_path);
        $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';

        $counter = 1;
        $newFileName = $request->file_name . $extension;
        $oldPath = $photoEvent->file_path;
        $newPath = dirname($oldPath) . '/' . $newFileName;

        // PhotoEvent::where('file_name', 'LIKE', '%' . $newFileName . '%')
        //     ->where('photo_event_type_id', $photoEvent->photo_event_type_id)
        //     ->where('branch_id', $photoEvent->branch_id)
        //     ->where('id_photo_event', '!=', $photoEvent->id_photo_event) // Mengecualikan dirinya sendiri
        //     ->exists()
        while (Storage::exists($newPath)) {
            $newFileName = $request->file_name . "($counter)" . $extension;
            $newPath = dirname($oldPath) . '/' . $newFileName;
            $counter++;
        }

        if (Storage::exists($oldPath)) {
            Storage::move($oldPath, $newPath);
        }

        $photoEvent->update([
            'file_path' => $newPath,
        ]);

        return Response::success(null, 'Rename berhasil');
    }

    public function destroy($photo_event)
    {
        DB::beginTransaction();

        try {
            $photoEvent = PhotoEvent::findOrFail($photo_event);
            $path = $photoEvent->file_path;

            if (Storage::exists($path)) {
                Storage::delete($path);
            }

            $photoEvent->delete();
            DB::commit();
            return Response::success(null, 'Foto berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e, 'Failed to delete data.');
        }
    }
}
