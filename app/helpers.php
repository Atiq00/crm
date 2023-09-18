<?php 

function setting($key){
	return  \App\Models\Setting::where('key', '=',  $key)->first()->value ?? '' ;
}


function reply_label($label)
{
	return '<span class="badge badge-pill badge-primary">'.$label.'</span>';
}

function status_label($label)
{
	if($label=='open')
		return '<span class="badge badge-success">'.__('labels.open').'</span>';
	elseif($label=='closed')
		return '<span class="badge badge-secondary">'.__('labels.closed').'</span>';

	return '<span class="badge badge-primary">'.$label.'</span>';
}

function front_status_label($label)
{
	if($label=='open')
		return '<span class="badge badge-pill badge-success">'.__('labels.open').'</span>';
	elseif($label=='closed')
		return '<span class="badge badge-pill badge-secondary">'.__('labels.closed').'</span>';

	return '<span class="badge badge-pill badge-primary">'.$label.'</span>';
}

function reply_status_label($label)
{
	if($label=='client_reply')
		$html = '<span class="badge badge-pill  badge-warning">'.__('labels.client_replied').'</span>';
	elseif($label=='agent_reply')
		$html = '<span class="badge badge-pill  badge-secondary">'.__('labels.answered').'</span>';

	return $html;
}

function front_reply_status_label($status)
{

	if($status=='client_reply')
		$html = '<span class="badge badge-pill  badge-secondary">'.__('labels.client_replied').'</span>';
	elseif($status=='agent_reply')
		$html = '<span class="badge badge-pill  badge-warning">'.__('labels.answered').'</span>';

	return $html;
}



function priority_label($priority)
{
	return '<span class="badge badge-pill" style="background-color: '.$priority->color.'; color: '.$priority->color_text.'">'.$priority->name.'</span>';
}


function decode_icon_url($img)
{
	$img = str_replace('{site_url}/', url('/').'/', $img);
	$img = str_replace('{asset_url}/', asset('/').'/', $img);
	$img = str_replace('{upload_url}/', url('uploads'), $img);
	$img = str_replace('{site_url}', url('/'), $img);
	$img = str_replace('{asset_url}', asset('/'), $img);
	$img = str_replace('{upload_url}', url('uploads'), $img);
	return $img;
}

function kb_category_url($kb_category)
{
	return route('kb.category_detail', [$kb_category->id, $kb_category->slug]);
}

function kb_sub_category_url($kb_sub_category)
{
	return route('kb.sub_category_detail', [$kb_sub_category->category->slug, $kb_sub_category->id, $kb_sub_category->slug]);
}

function kb_article_url($kb_article)
{
	return route('kb.article-detail', [$kb_article->id, $kb_article->slug]);
}


function alert_html($message, $type, $time = false)
{

	$uniqid = uniqid();

	$html = '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert" id="alert-'.$uniqid.'">
                  <span class="alert-icon"><i class="ni ni-bell-55"></i></span>
                  <span class="alert-text">&nbsp;&nbsp'.$message.'</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>';

    if($time){
    	$html .= '<script>setTimeout(() => {
    		$(\'#alert-'.$uniqid.'\').fadeOut(500);
    	}, '.$time.')</script>';
    }

	return $html;
	
}


function html_select_kb_categories($kb_categories, $name = 'category', $customAttr = [], $isRequired = false, $category_id = 0, $sub_category_id = 0)
{
	
	$html = ' <select name="'.$name.'" id="'.$name.'" data-toggle="select" '.$customAttr.' '. ($isRequired ? 'required' :'' ) .'>';

	$sel = $category_id <= 0 || $category_id == 'all' ? 'selected' : '';

	if(!$isRequired)
		$html .='<option value="all" '.$sel .'>'.__('labels.all_categories').'</option>';
	else
		$html .='<option value="" '.$sel .'>'.__('labels.select_category').'</option>';

        foreach($kb_categories as $cat){

        	$sel =	$sub_category_id <= 0 && $category_id == $cat->id ? 'selected' : '';
            $html .= '<option value="'.$cat->id.'" '.$sel.'>'.$cat->name.'</option>';
                                                
            foreach($cat->sub_categories as $sub_cat){
        		$sel =	$sub_category_id >0 && $sub_category_id == $sub_cat->id ? 'selected' : '';
                $html .= '<option value="'.$cat->id.'_'.$sub_cat->id.'" '.$sel.'>&nbsp; &nbsp; -- '.$sub_cat->name.'</option>';
            }

        }

    $html .= '</select>';

    return $html;
}

function getLanguages()
{

	$scanned_directory = array_diff(scandir( resource_path('lang') ), array('..', '.'));
	
	return $scanned_directory;
}

function shortcodes_Ticket($ticket)
{
	$ticketData = [
		'ticket_title' => $ticket->title,
		'ticket_description' => $ticket->description,
		'ticket_customer_url' => route('customer.tickets_view', $ticket->id),
		'ticket_agent_url' => route('tickets.show', $ticket->id),
		'ticket_url' => route('customer.tickets_view', $ticket->id),
	];

	return $ticketData;
}