<form method="post" action="{{ route('customer.ticket_reply', $ticket->id) }}" id="my-form" enctype="multipart/form-data">
    @csrf
    @method('post')
      <div class="form-group">
        <label class="require form-control-label">{{ __('labels.message') }}</label>
        <textarea name="reply_description" rows="5"  required minlength="5" class="form-control">{{ old('reply_description') }}</textarea>
        @if ($errors->has('reply_description'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('reply_description') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group file-group">
        <label class="require form-control-label">{{ __('labels.attachment') }}</label>
        <input type="file" class="form-control" multiple="" name="reply_attachments[]">
        @if ($errors->has('customer'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('customer') }}</strong>
            </span>
        @endif
    </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-icon">
        {{ __('labels.submit') }} &nbsp; <i data-feather="send" width="15" stroke-width="2"></i>
        </button>
      </div>
</form>