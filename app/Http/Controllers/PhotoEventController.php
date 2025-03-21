<?php

namespace App\Http\Controllers;

use App\Models\PhotoEvent;
use App\Models\PhotoEventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Response;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PhotoEventController extends Controller
{
    public function index(PhotoEventType $photoEventType, Request $request)
    {
        if ($request->ajax()) {
            $data = PhotoEvent::where('photo_event_type_id', $request->photo_event_type_id)
                ->where('branch_id', $request->branch_id)
                ->get()
                ->chunk(5);

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

        $photoEvents = PhotoEvent::where('photo_event_type_id', $photoEventType->id)->get();
        return view('photo_event.index', compact('photoEventType', 'photoEvents'));
    }

    public function getData(Request $request)
    {
        $data = PhotoEvent::where('photo_event_type_id', $request->photo_event_type_id)
            ->where('branch_id', $request->branch_id);

        $listSearch = ['file_path'];
        $data = self::filterDatatable($data, $listSearch);


        $data = $data->get()->chunk(5);

        // dd($data);

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
            'files.*' => 'required|image|mimes:jpeg,png,jpg|max:20048',
            'branch_id' => 'required|ulid',
            'photo_event_type_id' => 'required|ulid',
        ]);

        DB::beginTransaction();

        try {
            $branchName = strtolower(str_replace(' ', '-', Branch::findOrFail($request->branch_id)->branch_name));
                foreach ($request->file('files') as $file) {
                    $jenisEvent = strtolower(str_replace(' ', '-', $photoEventType->photo_event_type_name));
                    $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.' . $file->getClientOriginalExtension();
                    $newPath = "photo-event/{$jenisEvent}/{$branchName}/{$fileName}";

                    $counter = 1;
                    while (Storage::exists($newPath)) {
                        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "($counter)." . $file->getClientOriginalExtension();
                        $newPath = "photo-event/{$jenisEvent}/{$branchName}/{$fileName}";
                        $counter++;
                    }

                    $path = $file->storeAs("photo-event/{$jenisEvent}/{$branchName}/", $fileName);
                    PhotoEvent::create([
                        'photo_event_type_id' => $request->photo_event_type_id,
                        'branch_id' => $request->branch_id,
                        'file_path' => $path,
                    ]);
                }

                DB::commit();
                return Response::success(null, 'Upload berhasil');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::errorCatch($e, 'Upload gagal');
        }
    }

    public function update(Request $request, PhotoEvent $photoEvent)
    {
        $request->validate([
            'file_name' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            $oldPath = $photoEvent->file_path;
            $newPath = "photo-event/{$photoEvent->photoEventType->photo_event_type_name}/{$request->file_name}";

            if (Storage::exists($oldPath)) {
                Storage::move($oldPath, $newPath);
            }

            $photoEvent->update([
                'file_path' => $newPath,
            ]);

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
