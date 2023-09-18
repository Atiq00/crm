<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('uploads/logo/' . setting('site_logo')) . '?' . time() }}" class="navbar-brand-img"
                    alt="...">
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ in_array($current_page, ['dashboard']) ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="ni ni-tv-2"></i> <span class="nav-link-text">{{ __('labels.dashboard') }}</span>
                        </a>
                    </li>
                    @canany(['mortgages.*', 'mortgages.index', 'mortgages.create', 'mortgages.edit',
                        'mortgages.delete'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['mortgage', 'mortgage-submission']) ? 'active' : '' }}"
                                href="#nav-mortgages" data-toggle="collapse" role="button"
                                aria-expanded="{{ in_array($current_page, ['mortgage', 'mortgage-submission']) ? 'true' : 'false' }}"
                                aria-controls="nav-mortgages">
                                <i class="fa fa-home"></i>
                                <span class="nav-link-text">Debt</span>
                            </a>
                            <div class="collapse {{ in_array($current_page, ['mortgage', 'mortgage-submission']) ? 'show' : '' }}"
                                id="nav-mortgages">
                                <ul class="nav nav-sm flex-column">
                                    @canany(['mortgages.create'])
                                        <li class="nav-item">
                                            <a href="{{ route('mortgages.create') }}"
                                                class="nav-link {{ $current_page == 'mortgage-submission' ? 'active' : '' }}">Submission
                                                Form</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a href="{{ route('covid.create') }}"
                                                class="nav-link {{ $current_page == 'covid-submission' ? 'active' : '' }}">Submission
                                                Form Covid</a>
                                        </li> --}}
                                    @endcanany
                                    @canany(['mortgages.index'])
                                        <li class="nav-item">
                                            <a href="{{ route('mortgages.index') }}"
                                                class="nav-link {{ $current_page == 'mortgage' ? 'active' : '' }}">Sales-Sheet</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a href="{{ route('covid.index') }}"
                                                class="nav-link {{ $current_page == 'solar' ? 'active' : '' }}">Sales-Sheet Covid</a>
                                        </li> --}}
                                    @endcanany
                                   
                                    @canany(['mortgages.client'])
                                        {{-- <li class="nav-item">
                                        <a href="{{ route('mortgages.client') }}"
                                            class="nav-link {{ $current_page == 'mortgage' ? 'active' : '' }}">ClientSales-Sheet</a>
                                    </li> --}}
                                    @endcanany

                                </ul>
                            </div>
                        </li>
                    @endcanany
                    @canany(['solars.index', 'solars.create', 'solars.delete','austinphoenix'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['solar', 'solar-submission','austinphoenix']) ? 'active' : '' }}"
                                href="#nav-solars" data-toggle="collapse" role="button"
                                aria-expanded="{{ in_array($current_page, ['solar', 'solar-submission','austinphoenix']) ? 'true' : 'false' }}"
                                aria-controls="nav-solars">
                                <i class="fa fa-sun"></i>
                                <span class="nav-link-text">Solar</span>
                            </a>
                            <div class="collapse {{ in_array($current_page, ['solars', 'solar-submission','austinphoenix']) ? 'show' : '' }}"
                                id="nav-solars">
                                <ul class="nav nav-sm flex-column">
                                    @canany(['solars.create'])
                                        <li class="nav-item">
                                            <a href="{{ route('solars.create') }}"
                                                class="nav-link {{ $current_page == 'solar-submission' ? 'active' : '' }}">Submission
                                                Form</a>
                                        </li>
                                        @if(Auth::user()->id !=4875)
                                            <li class="nav-item">
                                                {{-- <a href="{{ route('covid.create') }}"
                                                    class="nav-link {{ $current_page == 'covid-submission' ? 'active' : '' }}">Submission
                                                    Form Covid</a> --}}
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ url('admin/enactcreate') }}"
                                                    class="nav-link {{ $current_page == 'solar-submission' ? 'active' : '' }}">Enact Solar
                                                    Form</a>
                                            </li>
                                        @endif
                                    @endcanany
                                    @canany(['solars.index'])
                                        <li class="nav-item">
                                            <a href="{{ route('solars.index') }}"
                                                class="nav-link {{ $current_page == 'solar' ? 'active' : '' }}">Sales-Sheet</a>
                                        </li>
                                        <li class="nav-item">
                                            {{-- <a href="{{ route('covid.index') }}"
                                                class="nav-link {{ $current_page == 'solar' ? 'active' : '' }}">Sales-Sheet Covid</a> --}}
                                        </li>
                                    @endcanany
                                    @canany(['austinphoenix.index'])
                                    <li class="nav-item">
                                        <a href="{{ route('austinphoenix.index') }}" class="nav-link {{ $current_page == 'solar' ? 'active' : '' }}">SOL Leads</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('austinphoenix_salesheet') }}" class="nav-link {{ $current_page == 'solar' ? 'active' : '' }}">SOL Salesheet</a>
                                    </li>
                                @endcanany
                                 
                                @if(Auth::user()->id =="4178" || Auth::user()->hasRole('Super Admin'))
                                <li class="nav-item">
                                    <a href="{{ route('agent.index') }}"
                                        class="nav-link {{ $current_page == 'solar' ? 'active' : '' }}">Agent Sale's count</a>
                                </li>
                                @endif
                            
                                    @canany(['solars.client'])
                                        {{-- <li class="nav-item">
                                    <a href="{{ route('solars.client') }}"
                                        class="nav-link {{ $current_page == 'solar' ? 'active' : '' }}">ClientSales-Sheet</a>
                                </li> --}}
                                    @endcanany
                                    
                                </ul>
                            </div>
                        </li>
                    @endcanany
                     {{-- <!-- Covid Kit Starts -->
                     @canany(['covid.*', 'covid.create', 'covid.index'])
                     <li class="nav-item">
                         <a class="nav-link {{ in_array($current_page, ['covid', 'covid-submission']) ? 'active' : '' }}"
                             href="#nav-covid" data-toggle="collapse" role="button"
                             aria-expanded="{{ in_array($current_page, ['covid', 'covid-submission']) ? 'true' : 'false' }}"
                             aria-controls="nav-covid">
                             <i class="fa fa-home"></i>
                             <span class="nav-link-text">Covid Kit</span>
                         </a>
                         <div class="collapse {{ in_array($current_page, ['covid', 'covid-submission']) ? 'show' : '' }}"
                             id="nav-covid">
                             <ul class="nav nav-sm flex-column">
                                 @canany(['covid.create'])
                                     <li class="nav-item">
                                         <a href="{{ route('covid.create') }}"
                                             class="nav-link {{ $current_page == 'covid-submission' ? 'active' : '' }}">Submission
                                             Form</a>
                                     </li>
                                 @endcanany
                                 @canany(['covid.index'])
                                     <li class="nav-item">
                                         <a href="{{ route('covid.index') }}"
                                             class="nav-link {{ $current_page == 'covid' ? 'active' : '' }}">Sales-Sheet</a>
                                     </li>
                                 @endcanany
                             </ul>
                         </div>
                     </li>
                 @endcanany
 
 
  --}}
                     <!-- Covid Kit ends -->


                          <!-- AMG stats starts -->
                          <!-- @canany(['amg.*', 'amg.create', 'amg.index'])
                          <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['amg', 'amg-submission']) ? 'active' : '' }}"
                                href="#nav-amgstats" data-toggle="collapse" role="button"
                                aria-expanded="{{ in_array($current_page, ['amg', 'amg-submission']) ? 'true' : 'false' }}"
                                aria-controls="nav-amgstats">
                                <i class="fa fa-home"></i>
                                <span class="nav-link-text">PCI</span>
                            </a>
                            <div class="collapse {{ in_array($current_page, ['amgstats', 'amgstats-submission']) ? 'show' : '' }}"
                                id="nav-amgstats">
                                <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link {{ in_array($current_page, ['amgstats', 'amgstats-submission']) ? 'active' : '' }}"
                                            href="#nav-amgtbb" data-toggle="collapse" role="button"
                                            aria-expanded="{{ in_array($current_page, ['amgstats', 'amgstats-submission']) ? 'true' : 'false' }}"
                                            aria-controls="nav-amgtbb">
                                            <i class="fa fa-home"></i>
                                            <span class="nav-link-text">AMG</span>
                                        </a>
                                        <div class="collapse {{ in_array($current_page, ['amgstats', 'amgstats-submission']) ? 'show' : '' }}"
                                        id="nav-amgtbb">
                                        <ul class="nav nav-sm flex-column">
                                            @canany(['amg.create'])
                                                <li class="nav-item">
                                                    <a href="{{ route('amg.create') }}"
                                                        class="nav-link {{ $current_page == 'amgstats-submission' ? 'active' : '' }}">AMG-
                                                        Form</a>
                                                </li>
                                                @endcanany
                                                @canany(['amg.index'])
                                                <li class="nav-item">
                                                    <a href="{{ route('amg.index') }}"
                                                        class="nav-link {{ $current_page == 'amgstats' ? 'active' : '' }}">AMG-Stats</a>
                                            </li>
                                            @endcanany
                                            <li class="nav-item">
                                                    <a class="nav-link {{ in_array($current_page, ['tbb', 'tbb-submission']) ? 'active' : '' }}"
                                                        href="#nav-tbb" data-toggle="collapse" role="button"
                                                        aria-expanded="{{ in_array($current_page, ['tbb', 'tbb-submission']) ? 'true' : 'false' }}"
                                                        aria-controls="nav-tbb">
                                                        <i class="fa fa-home"></i>
                                                        <span class="nav-link-text">TBB</span>
                                                    </a>
                                                    <div class="collapse {{ in_array($current_page, ['tbb', 'tbb-submission']) ? 'show' : '' }}"
                                                        id="nav-tbb">
                                                        <ul class="nav nav-sm flex-column">
                                                                <li class="nav-item">
                                                                    <a href="{{ route('tbb.create') }}"
                                                                        class="nav-link {{ $current_page == 'tbb-submission' ? 'active' : '' }}">TBB-
                                                                        Form</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                 <a href="{{ route('tbb.index') }}"
                                                                 class="nav-link {{ $current_page == 'tbb' ? 'active' : '' }}">TBB-Stats</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                        </ul>
                                    </div>
                                </ul>
                            </div>
                        </li>
                        @endcanany -->


                        <!-- AMG stats ends -->

                             <!-- AMG stats starts -->
                             @canany(['amg.*', 'amg.create', 'amg.index', 'tbb.*','tbb.create','tbb.index','tbbcall.*','tbbcall.create','tbbcall.index'])
                             <li class="nav-item">
                                     <a class="nav-link {{ in_array($current_page, ['amgstats', 'amgstats-submission']) ? 'active' : '' }}"
                                         href="#nav-amgstats" data-toggle="collapse" role="button"
                                         aria-expanded="{{ in_array($current_page, ['amgstats', 'amgstats-submission']) ? 'true' : 'false' }}"
                                         aria-controls="nav-amgstats">
                                         <i class="fa fa-home"></i>
                                         <span class="nav-link-text">PCI</span>
                                     </a>
                                     <div class="collapse {{ in_array($current_page, ['amgstats', 'amgstats-submission']) ? 'show' : '' }}"
                                         id="nav-amgstats">
                                         <ul class="nav nav-sm flex-column">
                                                 <li class="nav-item">
                                                    <a class="nav-link {{ in_array($current_page, ['amg', 'amg-submission']) ? 'active' : '' }}"
                                                        href="#nav-amg" data-toggle="collapse" role="button"
                                                        aria-expanded="{{ in_array($current_page, ['amg', 'amg-submission']) ? 'true' : 'false' }}"
                                                        aria-controls="nav-amg">
                                                        <i class="fa fa-home"></i>
                                                        <span class="nav-link-text">AMG</span>
                                                    </a>
                                                    <div class="collapse {{ in_array($current_page, ['amg', 'amg-submission']) ? 'show' : '' }}"
                                                        id="nav-amg">
                                                        <ul class="nav nav-sm flex-column">
                                                        @canany(['amg.create'])
                                                                <li class="nav-item">
                                                                    <a href="{{ route('amg.create') }}"
                                                                        class="nav-link {{ $current_page == 'amg-submission' ? 'active' : '' }}">AMG-
                                                                        Form</a>
                                                                </li>
                                                                @endcanany
                                                                @canany(['amg.index'])
                                                                <li class="nav-item">
                                                                 <a href="{{ route('amg.index') }}"
                                                                 class="nav-link {{ $current_page == 'amg' ? 'active' : '' }}">AMG-Stats</a>
                                                            </li>
                                                            @endcanany
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ in_array($current_page, ['tbb', 'tbb-submission']) ? 'active' : '' }}"
                                                        href="#nav-tbb" data-toggle="collapse" role="button"
                                                        aria-expanded="{{ in_array($current_page, ['tbb', 'tbb-submission']) ? 'true' : 'false' }}"
                                                        aria-controls="nav-tbb">
                                                        <i class="fa fa-home"></i>
                                                        <span class="nav-link-text">TBB EMAIL</span>
                                                    </a>
                                                    <div class="collapse {{ in_array($current_page, ['tbb', 'tbb-submission']) ? 'show' : '' }}"
                                                        id="nav-tbb">
                                                        <ul class="nav nav-sm flex-column">
                                                        @canany(['tbb.create'])
                                                                <li class="nav-item">
                                                                    <a href="{{ route('tbb.create') }}"
                                                                        class="nav-link {{ $current_page == 'tbb-submission' ? 'active' : '' }}">TBB-
                                                                        Form</a>
                                                                </li>
                                                                @endcanany
                                                                @canany(['tbb.index'])
                                                                <li class="nav-item">
                                                                 <a href="{{ route('tbb.index') }}"
                                                                 class="nav-link {{ $current_page == 'tbb' ? 'active' : '' }}">TBB-Stats</a>
                                                            </li>
                                                            @endcanany
                                                        </ul>
                                                    </div>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link {{ in_array($current_page, ['tbbcall', 'tbbcall-submission']) ? 'active' : '' }}"
                                                        href="#nav-tbbcall" data-toggle="collapse" role="button"
                                                        aria-expanded="{{ in_array($current_page, ['tbbcall', 'tbbcall-submission']) ? 'true' : 'false' }}"
                                                        aria-controls="nav-tbbcall">
                                                        <i class="fa fa-home"></i>
                                                        <span class="nav-link-text">TBB-CALL</span>
                                                    </a>
                                                    <div class="collapse {{ in_array($current_page, ['tbbcall', 'tbbcall-submission']) ? 'show' : '' }}"
                                                        id="nav-tbbcall">
                                                        <ul class="nav nav-sm flex-column">
                                                        @canany(['tbbcall.create'])
                                                                <li class="nav-item">
                                                                    <a href="{{ route('tbbcall.create') }}"
                                                                        class="nav-link {{ $current_page == 'tbbcall-submission' ? 'active' : '' }}">TBB-Call-
                                                                        Form</a>
                                                                </li>
                                                                @endcanany
                                                                @canany(['tbbcall.index'])
                                                                <li class="nav-item">
                                                                 <a href="{{ route('tbbcall.index') }}"
                                                                 class="nav-link {{ $current_page == 'tbb' ? 'active' : '' }}">TBB-Call-Stats</a>
                                                            </li>
                                                            @endcanany
                                                        </ul>
                                                    </div>
                                                </li>
                                              
                                         </ul>
                                     </div>
                                 </li>
                                 @endcanany


                                 <!-- AMG stats ends-->

    <!-- HomeWarranty External starts-->
                    @canany(['homewarrantyexternal.create','homewarrantyDGS.create','homewarrantyDGS','homewarrantyAMS.create','homewarrantyAMS'])
                    <li class="nav-item">
                        <a class="nav-link {{ in_array($current_page, ['home-warranty-external', 'home-warranty-external-submission','homewarrantyDGS','homewarrantyDGS-Submission']) ? 'active' : '' }}"
                            href="#nav-homewse" data-toggle="collapse" role="button"
                            aria-expanded="{{ in_array($current_page, ['home-warranty-external', 'home-warranty-external-submission','homewarrantyDGS','homewarrantyDGS-Submission']) ? 'true' : 'false' }}"
                            aria-controls="nav-homewse">
                            <i class="fa fa-bed"></i>
                            <span class="nav-link-text">External Portal</span>
                        </a>
                        <div class="collapse {{ in_array($current_page, ['home-warranty-external','alldebshea_external', 'home-warranty-external-submission','homewarrantyDGS','homewarrantyDGS-Submission']) ? 'show' : '' }}"
                            id="nav-homewse">
                            <ul class="nav nav-sm flex-column">
                                @canany(['homewarrantyexternal.create'])
                                    <li class="nav-item">
                                        <a href="{{ route('homewarrantyexternal.create') }}"
                                            class="nav-link {{ $current_page == 'home-warranty-external-submission' ? 'active' : '' }}">Benchmark Submission
                                        </a>
                                    </li>
                                @endcanany
                                    
                                @canany(['homewarrantyexternal.index'])
                                    <li class="nav-item">
                                        <a href="{{ route('homewarrantyexternal.index') }}"
                                            class="nav-link {{ $current_page == 'home-warranty-external' ? 'active' : '' }}">Benchmark Sales-Sheet
                                        </a>
                                    </li>
                                @endcanany


                                @canany(['homewarrantyexternal.create'])
                                    <li class="nav-item">
                                        <a href="{{ route('alldebshea_external.create') }}"
                                            class="nav-link {{ $current_page == 'alldebshea_external' ? 'active' : '' }}">All Debt Shea
                                        </a>
                                    </li>
                                @endcanany
                                    
                                @canany(['alldebshea_external.index'])
                                    <li class="nav-item">
                                        <a href="{{ route('alldebshea_external.index') }}"
                                            class="nav-link {{ $current_page == 'alldebshea_external' ? 'active' : '' }}">AllDebtShea Sales-Sheet
                                        </a>
                                    </li>
                                @endcanany
                                @canany(['homewarrantyDGS.create'])
                                    <li class="nav-item">
                                        <a href="{{ route('homewarrantyDGS.create') }}"
                                            class="nav-link {{ $current_page == 'homewarrantyDGS-Submission' ? 'active' : '' }}">DGS Submission
                                        </a>
                                    </li>
                                @endcanany
                                    
                                @canany(['homewarrantyDGS.index'])
                                    <li class="nav-item">
                                        <a href="{{ route('homewarrantyDGS.index') }}"
                                            class="nav-link {{ $current_page == 'homewarrantyDGS' ? 'active' : '' }}">DGS Sales-Sheet
                                        </a>
                                    </li>
                                @endcanany
                                @canany(['homewarrantyAMS.create'])
                                <li class="nav-item">
                                    <a href="{{ route('homewarrantyAMS.create') }}"
                                        class="nav-link {{ $current_page == 'homewarrantyAMS-Submission' ? 'active' : '' }}">AMS Submission
                                    </a>
                                </li>
                            @endcanany
                            @canany(['homewarrantyAMS.index'])
                                <li class="nav-item">
                                    <a href="{{ route('homewarrantyAMS.index') }}"
                                        class="nav-link {{ $current_page == 'homewarrantyAMS' ? 'active' : '' }}">AMS Sales-Sheet
                                    </a>
                                </li>
                            @endcanany
                            </ul>
                        </div>
                    </li>
                    @endcanany
                    <!-- HomeWarranty External ends-->


                               <!-- Uk Debt starts -->
                     @canany(['ukdebt.*', 'ukdebt.index', 'ukdebt.create', 'ukdebt.edit',
                    'ukdebt.delete'])
                    <li class="nav-item">
                        <a class="nav-link {{ in_array($current_page, ['ukdebt', 'ukdebt-submission']) ? 'active' : '' }}"
                            href="#nav-ukdebt" data-toggle="collapse" role="button"
                            aria-expanded="{{ in_array($current_page, ['ukdebt', 'ukdebt-submission']) ? 'true' : 'false' }}"
                            aria-controls="nav-ukdebt">
                            <i class="fa fa-home"></i>
                            <span class="nav-link-text">UK-Debt</span>
                        </a>
                        <div class="collapse {{ in_array($current_page, ['ukdebt', 'ukdebt-submission']) ? 'show' : '' }}"
                            id="nav-ukdebt">
                            <ul class="nav nav-sm flex-column">
                                  @canany(['ukdebt.create'])
                                    <li class="nav-item">
                                        <a href="{{ route('ukdebt.create') }}"
                                            class="nav-link {{ $current_page == 'ukdebt-submission' ? 'active' : '' }}">Submission
                                            Form</a>
                                    </li>
                                 @endcanany
                                  @canany(['ukdebt.index'])
                                    <li class="nav-item">
                                        <a href="{{ route('ukdebt.index') }}"
                                            class="nav-link {{ $current_page == 'ukdebt' ? 'active' : '' }}">Sales-Sheet</a>
                                    </li>
                                 @endcanany
                            </ul>
                        </div>
                    </li>
                 @endcanany

                    <!-- UK Debt ends-->


                    @canany(['home-warranties.index', 'home-warranties.create', 'home-warranties.delete'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['home-warranties', 'home-warranties-submission']) ? 'active' : '' }}"
                                href="#nav-homews" data-toggle="collapse" role="button"
                                aria-expanded="{{ in_array($current_page, ['home-warranties', 'home-warranties-submission']) ? 'true' : 'false' }}"
                                aria-controls="nav-homews">
                                <i class="fa fa-bed"></i>
                                <span class="nav-link-text">Home Warranty</span>
                            </a>
                            <div class="collapse {{ in_array($current_page, ['home-warranties', 'home-warranties-submission']) ? 'show' : '' }}"
                                id="nav-homews">
                                <ul class="nav nav-sm flex-column">
                                    @canany(['home-warranties.create', 'home-warranties.delete'])
                                        <li class="nav-item">
                                            <a href="{{ route('home-warranties.create') }}"
                                                class="nav-link {{ $current_page == 'home-warranties-submission' ? 'active' : '' }}">Submission
                                                Form</a>
                                        </li>
                                    @endcanany
                                    @canany(['home-warranties.index'])
                                        <li class="nav-item">
                                            <a href="{{ route('home-warranties.index') }}"
                                                class="nav-link {{ $current_page == 'home-warranties' ? 'active' : '' }}">Sales-Sheet</a>
                                        </li>
                                    @endcanany
                                </ul>
                            </div>
                        </li>
                    @endcanany
                    @canany(['campaigns.index', 'campaigns.create', 'campaigns.delete'])
                        
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['campaigns']) ? 'active' : '' }}"
                                href="{{ route('campaigns.index') }}">
                                <i class="fa fa-archive"></i> <span class="nav-link-text">Campaigns</span>
                            </a>
                        </li>
                    @endcanany
                    @canany(['clients.index', 'clients.create', 'clients.delete'])
                        
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['clients']) ? 'active' : '' }}"
                                href="{{ route('clients.index') }}">
                                <i class="fa fa-box"></i> <span class="nav-link-text">Clients</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['projects.index', 'projects.create', 'projects.delete'])
                        
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['projects']) ? 'active' : '' }}"
                                href="{{ route('projects.index') }}">
                                <i class="fa fa-list"></i> <span class="nav-link-text">Projects</span>
                            </a>
                        </li>
                    @endcanany
                    {{--                     @canany(['home-warranties.*', 'home-warranties.index', 'home-warranties.create', 'home-warranties.edit', 'home-warranties.delete'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['home-warranties', 'home-warranties-submission']) ? 'active' : '' }}"
                                href="#nav-homews" data-toggle="collapse" role="button"
                                aria-expanded="{{ in_array($current_page, ['home-warranties', 'home-warranties-submission']) ? 'true' : 'false' }}"
                                aria-controls="nav-homews">
                                <i class="ni ni-building"></i>
                                <span class="nav-link-text">Home Warranty</span>
                            </a>
                            <div class="collapse {{ in_array($current_page, ['home-warranties', 'home-warranties-submission']) ? 'show' : '' }}"
                                id="nav-homews">
                                <ul class="nav nav-sm flex-column">
                                    @canany(['home-warranties.*', 'home-warranties.index', 'home-warranties.create', 'home-warranties.edit', 'home-warranties.delete'])
                                        <li class="nav-item">
                                            <a href="{{ route('home-warranties.create') }}"
                                                class="nav-link {{ $current_page == 'home-warranties-submission' ? 'active' : '' }}">Submission
                                                Form</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('home-warranties.index') }}"
                                                class="nav-link {{ $current_page == 'home-warranties' ? 'active' : '' }}">Sales-Sheet</a>
                                        </li>
                                    @endcanany
                                </ul>
                            </div>
                        </li>
                    @endcanany --}}
                    <!-- Discount school supply starts -->
                    @canany(['dss.*', 'dss.index', 'dss.create', 'dss.edit', 'dss.delete'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['dss', 'dss-submission']) ? 'active' : '' }}"
                                href="#nav-dss" data-toggle="collapse" role="button"
                                aria-expanded="{{ in_array($current_page, ['dss', 'dss-submission']) ? 'true' : 'false' }}"
                                aria-controls="nav-dss">
                                <i class="fa fa-graduation-cap"></i>
                                <span class="nav-link-text">DSS</span>
                            </a>
                            <div class="collapse {{ in_array($current_page, ['dss', 'dss-submission']) ? 'show' : '' }}"
                                id="nav-dss">
                                <ul class="nav nav-sm flex-column">
                                    @canany(['dss.create'])
                                        <li class="nav-item">
                                            <a href="{{ route('dss.create') }}"
                                                class="nav-link {{ $current_page == 'dss-submission' ? 'active' : '' }}">Submission-Form</a>
                                        </li>
                                    @endcanany
                                    @canany(['dss.index'])
                                        <li class="nav-item">
                                            <a href="{{ route('dss.index') }}"
                                                class="nav-link {{ $current_page == 'dss' ? 'active' : '' }}">Sale-Sheet</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('dss.line-chart') }}"
                                                class="nav-link {{ $current_page == 'dss' ? 'active' : '' }}">Graphs</a>
                                        </li>
                                    @endcanany

                                </ul>
                            </div>
                        </li>
                    @endcanany
                    <!-- Discount school supply ends -->
                    
					    <!-- CRU starts -->
                 @canany(['cru.*', 'cru.index','cru.count'])
                 <li class="nav-item">
                     <a class="nav-link {{ in_array($current_page, ['CRU', 'CRU DATA DETAIL']) ? 'active' : '' }}"
                         href="#nav-cru" data-toggle="collapse" role="button"
                         aria-expanded="{{ in_array($current_page, ['CRU', 'CRU DATA DETAIL']) ? 'true' : 'false' }}"
                         aria-controls="nav-cru">
                         <i class="fa fa-graduation-cap"></i>
                         <span class="nav-link-text">CRU</span>
                     </a>
                     <div class="collapse {{ in_array($current_page, ['CRU', 'CRU DATA DETAIL']) ? 'show' : '' }}"
                         id="nav-cru">
                         <ul class="nav nav-sm flex-column">
                             @canany(['cru.index'])
                                 <li class="nav-item">
                                     <a href="{{ route('cru.index') }}"
                                         class="nav-link {{ $current_page == 'CRU DATA DETAIL' ? 'active' : '' }}">CRU DATA</a>
                                 </li>
                             @endcanany
                             @canany(['cruc.count'])
                                 <li class="nav-item">
                                     <a href="{{ route('cruc.count') }}"
                                         class="nav-link {{ $current_page == 'cru' ? 'active' : '' }}">CRU COUNT</a>
                                 </li>

                             @endcanany

                         </ul>
                     </div>
                 </li>
             @endcanany
             <!-- CRU ends -->
					 @canany(['cmu-sales.import-form'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['cmu-sales.import-form']) ? 'active' : '' }}"
                                href="{{ route('cmu-sales.import-form') }}">
                                <i class="fa fa-phone"></i> <span
                                    class="nav-link-text">CMU Sales</span>
                            </a>
                        </li>
                    @endcanany
                      <!-- Call analytics Sales Starts -->
                      @canany(['call-analytic-sales.import-form'])
                      <li class="nav-item">
                          {{-- <a class="nav-link {{ in_array($current_page, ['call-analytic-sales.import-form']) ? 'active' : '' }}"
                              href="{{ route('call-analytic-sales.import-form') }}">
                              <i class="ni ni-chart-bar-32"></i> <span
                                  class="nav-link-text">Call Analytics</span>
                          </a> --}}

                          <a class="nav-link {{ in_array($current_page, ['call-analytic-sales.import-form']) ? 'active' : '' }}"
                          href="#nav-cax" data-toggle="collapse" role="button"
                          aria-expanded="{{ in_array($current_page, ['call-analytic-sales.import-form']) ? 'true' : 'false' }}"
                          aria-controls="nav-cax">
                          <i class="fa fa-graduation-cap"></i>
                          <span class="nav-link-text">Call Analytics</span>
                      </a>
                      <div class="collapse {{ in_array($current_page, ['call-analytic-sales.import-form']) ? 'show' : '' }}"
                      id="nav-cax">
                      <ul class="nav nav-sm flex-column">
                              <li class="nav-item">
                                  <a href="{{ route('call-analytic-sales.import-form') }}"
                                      class="nav-link {{ $current_page == 'call-analytic-sales.import-form' ? 'active' : '' }}">Upload and View Data</a>
                              </li>
                      </ul>
                      <ul class="nav nav-sm flex-column">
                          <li class="nav-item">
                              <a href="{{ route('call-analytic-sales.stats') }}"
                                  class="nav-link {{ $current_page == 'call-analytic-sales.stats' ? 'active' : '' }}">CAX-Stats</a>
                          </li>
                  </ul>
                  </div>
                      </li>
                  @endcanany

                  <!--Call analytics Sales ends -->
					@canany(['eddy-sales.import-form'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['eddy-sales.import-form']) ? 'active' : '' }}"
                                href="{{ route('eddy-sales.import-form') }}">
                                <i class="ni ni-chart-bar-32"></i> <span class="nav-link-text">Eddy Sales</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['eddyusers']) ? 'active' : '' }}"
                                href="{{ route('eddyusers') }}">
                                <i class="fa fa-users"></i> <span class="nav-link-text">Eddy Users</span>
                            </a>
                        </li>
                    @endcanany
                    @canany(['kb.*', 'kb.index', 'kb.create', 'kb.edit', 'kb.delete', 'kb_category.*',
                        'kb_category.index', 'kb_category.create', 'kb_category.edit', 'kb_category.delete'])

                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['kb', 'kb_category', 'kb_sub_categories']) ? 'active' : '' }}"
                                href="#nav-knowledge_bases" data-toggle="collapse" role="button"
                                aria-expanded="{{ in_array($current_page, ['kb', 'kb_category', 'kb_sub_categories']) ? 'true' : 'false' }}"
                                aria-controls="nav-knowledge_bases">
                                <i class="ni ni-single-copy-04"></i>
                                <span class="nav-link-text">{{ __('labels.knowledge_bases') }}</span>
                            </a>
                            <div class="collapse {{ in_array($current_page, ['kb', 'kb_category', 'kb_sub_categories']) ? 'show' : '' }}"
                                id="nav-knowledge_bases">
                                <ul class="nav nav-sm flex-column">
                                    @canany(['kb.*', 'kb.index', 'kb.create', 'kb.edit', 'kb.delete'])
                                        <li class="nav-item">
                                            <a href="{{ route('knowledge_bases.index') }}"
                                                class="nav-link {{ $current_page == 'kb' ? 'active' : '' }}">{{ __('labels.knowledge_bases') }}</a>
                                        </li>
                                    @endcanany
                                    @canany(['kb_category.*', 'kb_category.index', 'kb_category.create', 'kb_category.edit',
                                        'kb_category.delete'])
                                        <li class="nav-item">
                                            <a href="{{ route('kb_categories.index') }}"
                                                class="nav-link {{ $current_page == 'kb_category' ? 'active' : '' }}">{{ __('labels.category') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('kb_sub_categories.index') }}"
                                                class="nav-link {{ $current_page == 'kb_sub_categories' ? 'active' : '' }}">{{ __('labels.sub_category') }}</a>
                                        </li>
                                    @endcanany
                                </ul>
                            </div>
                        </li>

                    @endcanany


                    @canany(['designation.*', 'designation.index', 'designation.create', 'designation.edit',
                        'designation.delete'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['designations']) ? 'active' : '' }}"
                                href="{{ route('designations.index') }}">
                                <i class="ni ni-books"></i> <span class="nav-link-text">Designation</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['priority.*', 'priority.index', 'priority.create', 'priority.edit', 'priority.delete'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['priorities']) ? 'active' : '' }}"
                                href="{{ route('priorities.index') }}">
                                <i class="ni ni-bullet-list-67"></i> <span
                                    class="nav-link-text">{{ __('labels.priority') }}</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['faq.*', 'faq.index', 'faq.create', 'faq.edit', 'faq.delete', 'faq_category.*',
                        'faq_category.index', 'faq_category.create', 'faq_category.edit', 'faq_category.delete'])

                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['faq', 'faq_category']) ? 'active' : '' }}"
                                href="#nav-faqs" data-toggle="collapse" role="button"
                                aria-expanded="{{ in_array($current_page, ['faq', 'faq_category']) ? 'true' : 'false' }}"
                                aria-controls="nav-faqs">
                                <i class="ni ni-folder-17"></i>
                                <span class="nav-link-text">{{ __('labels.faq') }}</span>
                            </a>
                            <div class="collapse {{ in_array($current_page, ['faq', 'faq_category']) ? 'show' : '' }}"
                                id="nav-faqs">
                                <ul class="nav nav-sm flex-column">
                                    @canany(['faq.*', 'faq.index', 'faq.create', 'faq.edit', 'faq.delete'])
                                        <li class="nav-item">
                                            <a href="{{ route('faqs.index') }}"
                                                class="nav-link {{ $current_page == 'faq' ? 'active' : '' }}">{{ __('labels.faqs') }}</a>
                                        </li>
                                    @endcanany
                                    @canany(['faq_category.*', 'faq_category.index', 'faq_category.create',
                                        'faq_category.edit', 'faq_category.delete'])
                                        <li class="nav-item">
                                            <a href="{{ route('faq-category.index') }}"
                                                class="nav-link {{ $current_page == 'faq_category' ? 'active' : '' }}">{{ __('labels.category') }}</a>
                                        </li>
                                    @endcanany
                                </ul>
                            </div>
                        </li>

                    @endcanany
                   

                    @canany(['department.*', 'department.index', 'department.create', 'department.edit',
                        'department.delete'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['departments']) ? 'active' : '' }}"
                                href="{{ route('departments.index') }}">
                                <i class="ni ni-books"></i> <span
                                    class="nav-link-text">{{ __('labels.departments') }}</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['priority.*', 'priority.index', 'priority.create', 'priority.edit', 'priority.delete'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['priorities']) ? 'active' : '' }}"
                                href="{{ route('priorities.index') }}">
                                <i class="ni ni-bullet-list-67"></i> <span
                                    class="nav-link-text">{{ __('labels.priority') }}</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['ticket.*', 'ticket.index', 'ticket.create', 'ticket.edit', 'ticket.delete',
                        'ticket_canned_messages.*', 'ticket_canned_messages.index', 'ticket_canned_messages.create',
                        'ticket_canned_messages.edit', 'ticket_canned_messages.delete'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['tickets', 'canned_messages']) ? 'active' : '' }}"
                                href="#nav-tickets" data-toggle="collapse" role="button"
                                aria-expanded="{{ in_array($current_page, ['tickets', 'canned_messages']) ? 'true' : 'false' }}"
                                aria-controls="nav-tickets">
                                <i class="fa fa-life-ring"></i>
                                <span class="nav-link-text">{{ __('labels.tickets') }}</span>
                            </a>
                            <div class="collapse {{ in_array($current_page, ['tickets', 'canned_messages']) ? 'show' : '' }}"
                                id="nav-tickets">
                                <ul class="nav nav-sm flex-column">
                                    @canany(['ticket_canned_messages.*', 'ticket_canned_messages.index',
                                        'ticket_canned_messages.create', 'ticket_canned_messages.edit',
                                        'ticket_canned_messages.delete'])
                                        <li class="nav-item">
                                            <a href="{{ route('canned_messages.index') }}"
                                                class="nav-link {{ $current_page == 'canned_messages' ? 'active' : '' }}">{{ __('labels.canned_messages') }}</a>
                                        </li>
                                    @endcanany
                                    @canany(['ticket.*', 'ticket.index', 'ticket.create', 'ticket.edit', 'ticket.delete'])
                                        <li class="nav-item">
                                            <a href="{{ route('tickets.index') }}"
                                                class="nav-link {{ $current_page == 'tickets' ? 'active' : '' }}">{{ __('labels.all_tickets') }}</a>
                                        </li>
                                        @canany(['ticket.*'])
                                            <li class="nav-item">
                                                <a href="{{ route('tickets.index', ['status' => 'unassigned']) }}"
                                                    class="nav-link">{{ __('labels.unassigned_tickets') }}
                                                    @if (($countTicket = \App\Models\Ticket::where('user_id', '<=', 0)->orWhere('user_id', '=', null)->count()) > 0)
                                                        &nbsp;&nbsp; <span
                                                            class="badge badge-danger badge-circle">{{ $countTicket }}</span>
                                                    @endif
                                                </a>

                                            </li>
                                        @endcanany
                                        <li class="nav-item">
                                            <a href="{{ route('tickets.index', ['status' => 'open']) }}"
                                                class="nav-link">{{ __('labels.open_tickets') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('tickets.index', ['status' => 'closed']) }}"
                                                class="nav-link">{{ __('labels.closed_tickets') }}</a>
                                        </li>
                                    @endcanany
                                </ul>
                            </div>
                        </li>
                    @endcanany

                    @canany(['customer.*', 'customer.index', 'customer.create', 'customer.edit', 'customer.delete'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['customers']) ? 'active' : '' }}"
                                href="{{ route('customers.index') }}">
                                <i class="fa fa-users"></i>
                                <span class="nav-link-text">{{ __('labels.customers') }}</span>
                            </a>
                        </li>
                    @endcanany

                    @canany(['users.*', 'users.index', 'users.create', 'users.edit', 'users.delete', 'role.*',
                        'role.index', 'role.create', 'role.edit', 'role.delete'])

                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['users', 'roles','lead_users','client user']) ? 'active' : '' }}"
                                href="#nav-users" data-toggle="collapse" role="button"
                                aria-expanded="{{ in_array($current_page, ['users', 'roles','lead_users','client user']) ? 'true' : 'false' }}"
                                aria-controls="nav-users">
                                <i class="fa fa-users"></i>
                                <span class="nav-link-text">{{ __('labels.users') }}</span>
                            </a>
                            <div class="collapse {{ in_array($current_page, ['roles', 'users','lead_users','client user']) ? 'show' : '' }}"
                                id="nav-users">
                                <ul class="nav nav-sm flex-column">
                                   
                                    @canany(['users.*', 'users.index', 'users.create', 'users.edit', 'users.delete'])
                                        <li class="nav-item">
                                            <a href="{{ route('users.index') }}"
                                                class="nav-link {{ $current_page == 'users' ? 'active' : '' }}">{{ __('labels.users') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('client_users') }}"
                                                class="nav-link {{ $current_page == 'client user' ? 'active' : '' }}">Client Users</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('lead_users') }}"
                                                class="nav-link {{ $current_page == 'lead_users' ? 'active' : '' }}">Lead Position Users</a>
                                        </li>
                                        @canany(['role.*', 'role.index', 'role.create', 'role.edit', 'role.delete'])
                                        <li class="nav-item">
                                            <a href="{{ route('roles.index') }}"
                                                class="nav-link {{ $current_page == 'roles' ? 'active' : '' }}">{{ __('labels.roles') }}</a>
                                        </li>
                                    @endcanany
                                    @endcanany
                                </ul>
                            </div>
                        </li>

                    @endcanany

                    @canany(['settings.*'])
                        <li class="nav-item">
                            <a class="nav-link {{ in_array($current_page, ['general_settings', 'frontend_settings', 'language_settings', 'api_settings', 'ticket_settings']) ? 'active' : '' }}"
                                href="#nav-settings" data-toggle="collapse" role="button"
                                aria-expanded="{{ in_array($current_page, ['faq']) ? 'true' : 'false' }}"
                                aria-controls="nav-settings">
                                <i class="fa fa-cog"></i>
                                <span class="nav-link-text">{{ __('labels.settings') }}</span>
                            </a>
                            <div class="collapse {{ in_array($current_page, ['general_settings', 'frontend_settings', 'language_settings', 'api_settings', 'ticket_settings']) ? 'show' : '' }}"
                                id="nav-settings">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('settings.general') }}"
                                            class="nav-link {{ $current_page == 'general_settings' ? 'active' : '' }}">{{ __('labels.general_settings') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('settings.language') }}"
                                            class="nav-link {{ $current_page == 'language_settings' ? 'active' : '' }}">{{ __('labels.language_settings') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('settings.api') }}"
                                            class="nav-link {{ $current_page == 'api_settings' ? 'active' : '' }}">{{ __('labels.api_settings') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('settings.frontend') }}"
                                            class="nav-link {{ $current_page == 'frontend_settings' ? 'active' : '' }}">{{ __('labels.frontend_settings') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('settings.ticket') }}"
                                            class="nav-link {{ $current_page == 'ticket_settings' ? 'active' : '' }}">{{ __('labels.ticket_settings') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('settings.email') }}"
                                            class="nav-link {{ $current_page == 'email_settings' ? 'active' : '' }}">{{ __('labels.email_settings') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('settings.email_templates') }}"
                                            class="nav-link {{ $current_page == 'email_templates' ? 'active' : '' }}">{{ __('labels.email_templates') }}</a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                    @endcanany

                </ul>

            </div>
        </div>
    </div>
</nav>
