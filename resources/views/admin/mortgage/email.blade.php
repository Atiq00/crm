@extends('admin.layouts.app', [ 'current_page' => 'mortgage' ])

@section('content')


    @include('admin.layouts.headers.cards', ['title' => "Mortgage"])

    
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>First Name : </strong>
                {{ Hi @$firstname }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>The process is very simple and best of all it will not affect your credit or cost you anything to Unlock your preferred offer.
                        Remember, We provide you a cash investment in exchange for a small percentage of your home’s value.
                        The best part is there are no monthly payments or interest.
                        This program allows you to get the cash you need now and does not increase your monthly outgo.
                        Unlock your offer by filling your information here >> https://eur06.safelinks.protection.outlook.com/?url=https%3A%2F%2Fwww.unlksite.com%2F8LJN3%2FGTSC3%2F&data=05%7C01%7Casbutt%40touchstone.com.pk%7C3f571cdc1d0141fec08308db3aa2d360%7C29fd31c1899747c7a4fe3f19217eb679%7C0%7C0%7C638168243224677640%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C3000%7C%7C%7C&sdata=HPvReftHBJL2HV4mYX3cP9Qhl%2BL6q3oDMtl0w6QjklQ%3D&reserved=0
                        There is no cost or obligation and if you decide to move forward there are no out-of-pocket cost including the appraisal.
                        This is the best possible way to access cash now and we look forward to helping you Unlock the offer that is right for you.
 
                        Home Advisory Team
                        Equity Tap USA
                        Click here for info video
                        P 949-209-0636
                        www.equitytapUSA.com 
                    </strong>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email : </strong>
                {{  @$email }}
            </div>
        </div>

    </div>
        @include('admin.layouts.footers.auth')


    </div>
@endsection

