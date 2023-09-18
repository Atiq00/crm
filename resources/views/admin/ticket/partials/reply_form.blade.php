<form method="post" action="{{ route('tickets.add_reply', $ticket->id) }}" id="my-form" enctype="multipart/form-data">
    
    @csrf
    
    <div class="row">
        <div class="col-6">
            <div class="form-group file-group">
                <label class="require form-control-label">{{ __('labels.attachments') }}</label>
                <input type="file" class="form-control" multiple="" name="reply_attachments[]">
                @if ($errors->has('customer'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('customer') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="require form-control-label">{{ __('labels.canned_messages') }}</label>
                <select name="canned_message" id="canned_message" class="select2-select" onchange="updateTempMessage(this.value)">
                    <option value="">Select Canned Messages</option>
                    @foreach($canned_messages as $message)
                        <option value="{{ $message->id }}">{{ $message->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="require form-control-label">{{ __('labels.message') }}</label>
        <textarea name="reply_description" id="replyMessage" rows="5"  required class="form-control">{{ old('reply_description') }}</textarea>
        @if ($errors->has('reply_description'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('reply_description') }}</strong>
            </span>
        @endif
    </div>
    
    

    <label class="require form-control-label">{{ __('labels.status') }}</label>
    <div class="col-4 row">
        <div class="custom-control col custom-radio mb-4">
            <input name="update_status" class="custom-control-input" id="customRadio5" value="open" {{ $ticket->status == 'open' ? 'checked' : '' }} type="radio">
            <label class="custom-control-label" for="customRadio5">{{ __('labels.open') }}</label>
        </div>
        <div class="custom-control col custom-radio mb-4">
            <input name="update_status" class="custom-control-input" id="customRadio6" value="closed" {{ $ticket->status == 'closed' ? 'checked' : '' }} type="radio">
            <label class="custom-control-label" for="customRadio6">{{ __('labels.closed') }}</label>
        </div>
    </div>

    <button class="btn btn-primary" type="submit">{{ __('labels.send') }}</button>

</form>

<script>
window.updateTempMessage = (val) =>  {

    if(val==''){
        $('#replyMessage').val( '' );
        return;
    }

    $.get('{{ route('canned_messages.json_data') }}', { id: val }).done((data) => {
        try{
            $('#replyMessage').val( data.message );
        }catch(e){
            alert('Failed to get Canned Message ! Refresh page & Try Again !')
        }
        
    });

};
</script>