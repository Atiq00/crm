<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CkeditorUploadController extends Controller
{
    /**
 * upload images from ckeditor.
 *
 * @param Request $request
 * @return \Illuminate\Http\Response
 */
 public function upload_images(Request $request)
 {
      $request->validate([
          'upload' => 'image',
      ]);
      if ($request->hasFile('upload')) {
            $url = $request->upload->store('ckeditor_files', 'uploads');
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('uploads/' . $url);
            $msg =  __('messages.image_uploaded');
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            return $response;
        }
}
}
