<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Requests\CampaignRequest;

use App\User;

class CampaignController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->share('site', (object) [
            'title' =>  __('labels.campaigns')
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        
        $this->authorize('campaign.index');
        $campaigns = Campaign::all();
        $users = User::get();
        
        return view('admin.campaign.index', compact('campaigns', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $this->authorize('campaign.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CampaignRequest $request)
    {        
        $this->authorize('campaign.create');

        $campaign = $request->all();
        
        //$campaign['assigned_user_id'] =  $campaign['assigned_user_id'] > 0 ? $campaign['assigned_user_id'] : null ;

        $campaign = Campaign::create( $campaign );
        return redirect()->route('campaigns.index')->with('success', __('messages.campaign_created'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campaign)
    {        
        $this->authorize('campaign.index');
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campaign)
    {        
        $this->authorize('campaign.edit');
        $users = User::get();
        return view('admin.campaign.edit', compact('campaign', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function update(CampaignRequest $request, Campaign $campaign)
    {        
        $this->authorize('campaign.update');
        
        $campaign->update($request->all());

        return redirect()->route('campaigns.index')->with('success',__('messages.campaign_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campaign)
    {        
        $this->authorize('campaign.delete');
        $campaign->delete();
        return redirect()->route('campaigns.index')->with('success', __('messages.campaign_deleted'));
    }
}
