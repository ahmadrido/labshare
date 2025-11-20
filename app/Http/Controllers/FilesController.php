<?php
namespace App\Http\Controllers;

use App\Models\files;
use App\Models\downloads;
use App\Models\subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;


class FilesController extends BaseController
{
    public function __construct()
    {
        $this->middleware('permission:upload files')->only(['create', 'store']);
        $this->middleware('permission:edit files')->only(['edit', 'update']);
        $this->middleware('permission:delete files')->only(['destroy']);
        $this->middleware('permission:view files')->only(['index', 'show', 'download']);
    }

    public function index(Request $request)
    {
        $query = files::with(['subject', 'user']);
        
        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        // Filter by Subject
        if ($request->filled('subject')) {
            $query->where('subject_id', $request->subject);
        }
        
        // Filter by Type
        if ($request->filled('type')) {
            $query->where('file_type', $request->type);
        }
        
        // Sort
        if ($request->sort == 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }
        
        $files = $query->get();
        $subjects = subjects::all();
        
        return view('files.index', compact('files', 'subjects'));
    }

    public function create()
    {
        $subjects = subjects::all();
        return view('files.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required',
            'type' => 'required',
            'file' => 'required|file|max:5120',
            'description' => 'nullable'
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        files::create([
            'subject_id' => $request->subject_id,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'file_type' => $request->type,
            'file_path' => $path,
            'description' => $request->description,
        ]);

        return redirect()->route('files.index')->with('success', 'File uploaded successfully!');
    }

    public function edit(Files $file)
    {
        $subjects = Subjects::all();
        return view('files.edit', compact('file', 'subjects'));
    }

    public function update(Request $request, Files $file)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required',
            'type' => 'required',
            'file' => 'nullable|file|max:5120',
            'description' => 'nullable'
        ]);

        $data = $request->only(['subject_id', 'title', 'type', 'description']);
        $data['file_type'] = $request->type;

        if ($request->hasFile('file')) {
            // Hapus file lama
            Storage::disk('public')->delete($file->file_path);

            // Upload baru
            $data['file_path'] = $request->file('file')->store('uploads', 'public');
        }

        $file->update($data);

        return redirect()->route('files.index')->with('success', 'File updated successfully!');
    }


public function download(files $file)
{
    if (Auth::check()) {
        downloads::create([
            'file_id' => $file->id,
            'user_id' => Auth::id(),
            'downloaded_at' => now(),
        ]);
    }

    return Storage::disk('public')->download($file->file_path);
}


    public function destroy(files $file)
    {
        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return back()->with('success', 'File deleted.');
    }

        public function dashboard()
    {
        // Total Statistics
        $totalFiles = files::count();
        $totalSubjects = subjects::count();
        $totalDownloads = downloads::count();
        $myUploads = files::where('user_id', Auth::id())->count();

        // Recent Files (last 5)
        $recentFiles = files::with(['subject', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // File Types Distribution
        $fileTypeStats = files::select('file_type', DB::raw('count(*) as count'))
            ->groupBy('file_type')
            ->pluck('count', 'file_type')
            ->toArray();

        // Popular Downloads (top 5 most downloaded)
        $popularFiles = files::withCount('downloads')
            ->orderBy('downloads_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalFiles',
            'totalSubjects',
            'totalDownloads',
            'myUploads',
            'recentFiles',
            'fileTypeStats',
            'popularFiles'
        ));
    }

}
