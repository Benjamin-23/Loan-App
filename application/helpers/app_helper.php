<?php

function getDomain()
{
    $CI = & get_instance();
    return str_replace("index.php", "", site_url()); 
}

function get_last_payment_date($loan_id)
{
    $ci = & get_instance();
    $ci->db->where("loan_id", $loan_id);
    $ci->db->where("date_paid > ", 0);
    $ci->db->order_by("loan_payment_id", "desc");
    $ci->db->limit(1);
    $query = $ci->db->get("loan_payments");
    
    if ( $query->num_rows() > 0 )
    {
        return date("m/d/Y", $query->row()->date_paid);
    }
    
    return '';
}

function ifNull($var)
{
    if ( !isset($var) )
    {
        $var = '';
    }
    
    return $var;
}

function send($arr)
{
    echo json_encode($arr);
}
