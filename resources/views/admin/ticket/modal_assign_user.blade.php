<div class="modal fade" id="modal-assign-user-ticket-form" tabindex="-1" role="dialog" aria-labelledby="modal-assign-user-ticket-form" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
            	
                <div class="card bg-secondary border-0 mb-0">

                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <small>{{ __('labels.select_agent_info') }}</small>
                        </div>
                        <form role="form" action="{{ route('tickets.assign_user') }}" method="post">
                            @csrf


                            <input type="hidden" name="ticket_ids" id="assign_user_ticket_ids" value="{{isset($ticket_id) ? $ticket_id : ''}}" />
                            <div class="form-group mb-3">
                                <select name="user" id="input-user" class="form-control" data-toggle="select">
                                    <option value="0">{{ __('labels.select') }}</option>
                                    
                                    @foreach(\App\User::get() as $user)
                                        <option value="{{ $user->id }}" {{ isset($user_id) && $user_id==$user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="text-center">
                                <button type="reset" class="btn btn-secondary my-4" data-dismiss="modal">{{ __('labels.cancel') }}</button>
                                <button type="submit" class="btn btn-primary my-4">{{ __('labels.assign_user') }}</button>
                            </div>
                        </form>
                    </div>
                </div>



                
            </div>
            
        </div>
    </div>
</div>