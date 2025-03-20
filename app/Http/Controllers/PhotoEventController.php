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

        $listSearch = ['file_name'];
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
            'files.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'branch_id' => 'required|ulid',
            'photo_event_type_id' => 'required|ulid',
        ]);

        $branchName = Branch::where('id_branch', $request->branch_id)->first()->branch_name;
        foreach ($request->file('files') as $file) {
            $fileName = $file->getClientOriginalName();
            $jenisEvent = strtolower(str_replace(' ', '-', $photoEventType->photo_event_type_name));
            $path = $file->storeAs("photo-event/{$jenisEvent}/{$branchName}", $fileName);

            $counter = 1;
            while (PhotoEvent::where('file_name', 'LIKE', '%' . $fileName . '%')
            ->where('photo_event_type_id', $request->photo_event_type_id)
            ->where('branch_id', $request->branch_id)->exists()) {
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . "($counter)." . $file->getClientOriginalExtension();
                $path = $file->storeAs("photo-event/{$jenisEvent}/{$branchName}/", $fileName);
                $counter++;
            }

            PhotoEvent::create([
                'photo_event_type_id' => $request->photo_event_type_id,
                'branch_id' => $request->branch_id,
                'file_name' => $path,
            ]);
        }

        return Response::success(null, 'Upload berhasil');
    }

    public function update(Request $request, PhotoEvent $photoEvent)
    {
        $request->validate([
            'file_name' => 'required|string|unique:photo_events,file_name,' . $photoEvent->id,
        ]);

        $oldPath = "photo-event/{$photoEvent->photoEventType->photo_event_type_name}/{$photoEvent->file_name}";
        $newPath = "photo-event/{$photoEvent->photoEventType->photo_event_type_name}/{$request->file_name}";

        if (Storage::exists($oldPath)) {
            Storage::move($oldPath, $newPath);
        }

        $photoEvent->update([
            'file_name' => $request->file_name,
        ]);

        return Response::success(null, 'Update berhasil');
    }

    public function rename(Request $request, PhotoEvent $photoEvent)
    {
        //  test error
        // return Response::error(null, 'Error');
        $request->validate([
            'file_name' => 'required|string',
        ]);

        $pathInfo = pathinfo($photoEvent->file_name);
        $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';

        $counter = 1;
        $newFileName = $request->file_name . $extension;

        while (PhotoEvent::where('file_name', 'LIKE', '%' . $newFileName . '%')
            ->where('photo_event_type_id', $photoEvent->photo_event_type_id)
            ->where('branch_id', $photoEvent->branch_id)
            ->where('id_photo_event', '!=', $photoEvent->id_photo_event) // Mengecualikan dirinya sendiri
            ->exists()) {

            $newFileName = $request->file_name . "($counter)" . $extension;
            $counter++;
        }


        $oldPath = $photoEvent->file_name;
        $newPath = dirname($oldPath) . '/' . $newFileName;
        if (Storage::exists($oldPath)) {
            Storage::move($oldPath, $newPath);
        }

        $photoEvent->update([
            'file_name' => $newPath,
        ]);

        return Response::success(null, 'Rename berhasil');
    }

    public function destroy($photo_event)
    {
        DB::beginTransaction();

        try {
            $photoEvent = PhotoEvent::findOrFail($photo_event);
            $path = $photoEvent->file_name;

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
