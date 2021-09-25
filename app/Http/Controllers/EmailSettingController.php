<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailSetting;

class EmailSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', EmailSetting::class);
        return view('settings/email')
            ->with('email_setting', new EmailSetting);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', EmailSetting::class);

        $email_setting = new EmailSetting();
        $email_setting->env_email                       = $request->input('env_email');
        $email_setting->env_password                    = $request->input('env_password');
        $email_setting->env_name                        = $request->input('env_name');
        $email_setting->env_driver                      = $request->input('env_driver');
        $email_setting->env_host                        = $request->input('env_host');
        $email_setting->env_port                        = $request->input('env_port');
        $email_setting->env_mailfromaddr                = $request->input('env_mailfromaddr');
        $email_setting->env_replytoaddr                 = $request->input('env_replytoaddr');
        $email_setting->env_replytoname                 = $request->input('env_replytoname');

        if ($email_setting->save()) {
            return redirect()->route('settings.index')
                ->with('success', trans('admin/settings/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($setting->getErrors());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
