<?php
class wztlaw_index{
    public function __construct() {
       
        if(isset($_POST['wztlaw']) && $_POST['wztlaw']==1){
            $this->data = $_POST;
            
            $this->wztlaw_post();
        }
        
    }
    public function wztlaw_post(){
        $data = $this->data;
        if(isset($data['nonce']) && isset($data['action']) && wp_verify_nonce($data['nonce'],$data['action'])){
            if(isset($data['wztlaw_message']) && $data['wztlaw_message']==1){
                $this->wztlaw_message();
            }
        }
    }
    public function wztlaw_message(){
        global $wpdb;
        $data = $this->data;
        $res = $wpdb->insert($wpdb->prefix."wztlaw_message",['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email'],'address'=>$data['address'],'content'=>$data['content']]);
        if($res){
             echo json_encode(['msg'=>'留言成功，感谢您的支持！','code'=>1]);exit;
        }else{
             echo json_encode(['msg'=>'留言失败，请刷新页面后重试！','code'=>0]);exit;
        }
    }
    
}