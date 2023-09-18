<div class="list-group">
  
  <a href="{{ route('settings.general') }}" class="list-group-item list-group-item-action {{ $settingSidebarActive=='general' ? 'active' : '' }}">
    {{ __('labels.general_settings') }}
  </a>
  
  <a href="{{ route('settings.language') }}" class="list-group-item list-group-item-action {{ $settingSidebarActive=='language' ? 'active' : '' }}">{{ __('labels.language_settings') }}</a>

  <a href="{{ route('settings.api') }}" class="list-group-item list-group-item-action {{ $settingSidebarActive=='api' ? 'active' : '' }}">{{ __('labels.api_settings') }}</a>

  <a href="{{ route('settings.frontend') }}" class="list-group-item list-group-item-action {{ $settingSidebarActive=='frontend' ? 'active' : '' }}">{{ __('labels.frontend_settings') }}</a>

  <a href="{{ route('settings.ticket') }}" class="list-group-item list-group-item-action {{ $settingSidebarActive=='ticket' ? 'active' : '' }}">{{ __('labels.ticket_settings') }}</a>

  <a href="{{ route('settings.email') }}" class="list-group-item list-group-item-action {{ $settingSidebarActive=='email' ? 'active' : '' }}">{{ __('labels.email_settings') }}</a>

  <a href="{{ route('settings.email_templates') }}" class="list-group-item list-group-item-action {{ $settingSidebarActive=='email_templates' ? 'active' : '' }}">{{ __('labels.email_templates') }}</a>
</div>