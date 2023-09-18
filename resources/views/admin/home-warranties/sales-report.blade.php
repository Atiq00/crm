<table class="table align-items-center table-flush">
    <thead class="thead-light">
        <tr>
           <th scope="col">No</th>
            
            <th scope="col">Created Date</th>
            <th scope="col">HRMS ID</th>
			 <th scope="col">Pseudonym</th>
			<th scope="col">RecordID</th>
            <!--<th scope="col">Agent Name</th>-->
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Phone</th>
            @if(auth()->user()->hasRole('Super Admin'))
            <th scope="col">Phone</th>
            @endif
            <th scope="col">State</th>
            <th scope="col">Closers</th>
            <th scope="col">Other Closers</th>
            
            <th scope="col">QA-status</th>
            <th scope="col">Client-status</th>
            <th scope="col">ReportingTo</th>
            <th scope="col">Remarks</th>
            <th scope="col">Client</th>
            <th scope="col">Project</th>
            <th scope="col">Status</th>
			@if(auth()->user()->hasRole('MortgageClient') || auth()->user()->hasRole('Super Admin'))
			<th scope="col" width="10%">Client Status</th>		 
			@endif
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (count($home_warranties) > 0)
            @foreach ($home_warranties as $home_warranty)
                <tr>
                    <!-- {{ ($home_warranty->reporting ) }} -->
                    <td>{{$loop->iteration}}</td>
                    <td width="3%">{{ $home_warranty->created_at ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->hrms_id ?? '' }}</td>
					<td width="3%">{{ $home_warranty->agent_detail->pseudo_name ?? '' }}-{{ $home_warranty->agent_detail->name ?? '' }}</td>
					<td width="3%">{{ $home_warranty->record_id ?? '' }}</td>
                    {{-- <!--<td>{{ $home_warranty->agent_detail->name ?? '' }}</td>--> --}}
                    <td width="3%">{{ $home_warranty->first_name ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->last_name ?? '' }}</td>
                    <td width="3%">{{substr($home_warranty->phone, 0, 3) }}***{{ substr($home_warranty->phone,-4) }}</td>
                    @if(auth()->user()->hasRole('Super Admin'))
                    <td width="3%">{{$home_warranty->phone }}</td>
                    @endif
                    <td width="3%">{{ $home_warranty->state ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->closers ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->other_closers ?? '' }}</td>
                    
                    <td width="3%">{{ $home_warranty->qa_status ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->client_status ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->user->reporting->name ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->remarks ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->client->name ?? '' }}</td>
                    <td width="3%">{{ $home_warranty->project->name ?? '' }}</td>
                    
                    <td width="3%">{{ $home_warranty->status ?? '' }}</td>
					
					
					@if(auth()->user()->hasRole('MortgageClient') || auth()->user()->hasRole('Super Admin'))
					<?php $status = ['billable'=>"Accepeted",'not-billable'=>"Rejected" ,'pending'=>"Pending"];?>
					<td width="3%"> 
						<select onchange="remarks(this.value,{{$home_warranty->id}})" class="form-control bg bg-default">
							@foreach($status as $key=> $st)
							<option 
									@if($key==$home_warranty->client_status) 
								{{'selected'}} 
								@endif
								@if( $home_warranty->client_status !="pending") 
								{{'disabled'}} 
								@endif
								value="{{$key}}">{{ ($st)}}</option>
							@endforeach
						</select>
					</td>

					@endif
                    <td width="3%">
                        <a href="{{ route('home-warranties.show', $home_warranty) }}" class="btn btn-success btn-sm"><i
                                class="fas fa-eye"></i></a>
                        <a href="{{ route('home-warranties.edit', $home_warranty) }}" class="btn btn-primary btn-sm"><i
                                class="fas fa-edit"></i></a>
                        @if (in_array(Auth::user()->roles[0]->name, ['Super Admin']))
                            <a href="{{ route('home-warranties.delete', $home_warranty) }}"
                                class="btn btn-warning btn-sm"><i class="fas fa-trash"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center">No record found!</td>
            </tr>
        @endif

    </tbody>

</table>
