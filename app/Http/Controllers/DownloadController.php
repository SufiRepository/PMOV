<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DownloadController extends Controller
{
    /*get file from project storage*/
    public function download_project(Request $request)
    {
        if (Storage::disk('public')->exists("project_files/$request->file")) {
            $path = Storage::disk('public')->path("project_files/$request->file");
            $content = file_get_contents($path);
            return response($content)->withHeaders([
                'Content-Type' => mime_content_type($path)
            ]);
        }
        return back()
        ->with('success','File has been downloaded.');
    }

    /*get file from implementation storage*/
    public function download_implementation(Request $request)
    {
        if (Storage::disk('public')->exists("implementation_files/$request->file")) {
            $path = Storage::disk('public')->path("implementation_files/$request->file");
            $content = file_get_contents($path);
            return response($content)->withHeaders([
                'Content-Type' => mime_content_type($path)
            ]);
        }
        return back()
        ->with('success','File has been downloaded.');
    }

    /*get file from task storage*/
    public function download_task(Request $request)
    {
        if (Storage::disk('public')->exists("task_files/$request->file")) {
            $path = Storage::disk('public')->path("task_files/$request->file");
            $content = file_get_contents($path);
            return response($content)->withHeaders([
                'Content-Type' => mime_content_type($path)
            ]);
        }
        return back()
        ->with('success','File has been downloaded.');
    }

    /*get file from task storage*/
    public function download_subtask(Request $request)
    {
        if (Storage::disk('public')->exists("subtask_files/$request->file")) {
            $path = Storage::disk('public')->path("subtask_files/$request->file");
            $content = file_get_contents($path);
            return response($content)->withHeaders([
                'Content-Type' => mime_content_type($path)
            ]);
        }
        return back()
        ->with('success','File has been downloaded.');
    }

    /*get file from paymenttask (purchase order) storage*/
    public function download_po(Request $request)
    {
        if (Storage::disk('public')->exists("paymenttasks/$request->file")) {
            $path = Storage::disk('public')->path("paymenttasks/$request->file");
            $content = file_get_contents($path);
            return response($content)->withHeaders([
                'Content-Type' => mime_content_type($path)
            ]);
        }
        return back()
        ->with('success','File has been downloaded.');
    }

    /*get file from paymenttask (delivery order) storage*/
    public function download_do(Request $request)
    {
        if (Storage::disk('public')->exists("paymenttasks/$request->file")) {
            $path = Storage::disk('public')->path("paymenttasks/$request->file");
            $content = file_get_contents($path);
            return response($content)->withHeaders([
                'Content-Type' => mime_content_type($path)
            ]);
        }
        return back()
        ->with('success','File has been downloaded.');
    }

    /*get file from paymenttask (supported documents) storage*/
    public function download_sd(Request $request)
    {
        if (Storage::disk('public')->exists("paymenttasks/$request->file")) {
            $path = Storage::disk('public')->path("paymenttasks/$request->file");
            $content = file_get_contents($path);
            return response($content)->withHeaders([
                'Content-Type' => mime_content_type($path)
            ]);
        }
        return back()
        ->with('success','File has been downloaded.');
    }

    /*get file from paymenttask (purchase order) storage*/
    public function download_subtask_po(Request $request)
    {
        if (Storage::disk('public')->exists("paymentsubtask/$request->file")) {
            $path = Storage::disk('public')->path("paymentsubtask/$request->file");
            $content = file_get_contents($path);
            return response($content)->withHeaders([
                'Content-Type' => mime_content_type($path)
            ]);
        }
        return back()
        ->with('success','File has been downloaded.');
    }

    /*get file from paymenttask (delivery order) storage*/
    public function download_subtask_do(Request $request)
    {
        if (Storage::disk('public')->exists("paymentsubtask/$request->file")) {
            $path = Storage::disk('public')->path("paymentsubtask/$request->file");
            $content = file_get_contents($path);
            return response($content)->withHeaders([
                'Content-Type' => mime_content_type($path)
            ]);
        }
        return back()
        ->with('success','File has been downloaded.');
    }

    /*get file from paymenttask (supported documents) storage*/
    public function download_subtask_sd(Request $request)
    {
        if (Storage::disk('public')->exists("paymentsubtask/$request->file")) {
            $path = Storage::disk('public')->path("paymentsubtask/$request->file");
            $content = file_get_contents($path);
            return response($content)->withHeaders([
                'Content-Type' => mime_content_type($path)
            ]);
        }
        return back()
        ->with('success','File has been downloaded.');
    }
}
