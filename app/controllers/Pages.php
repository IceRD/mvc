<?php

use App\Lib;

class Pages extends Controller{

   public function index(){
      //if( isLoggedIn() ) {
      //   redirect('tasks');
      //}
      $data = [
         'title' => 'Hello Task!',
         'description' => ''
      ];
      $this->view('pages/index', $data);
   }

   //    public function about()
   //    {
   //       $data = [
   //           'title' => 'About Us',
   //           'description' => ''
   //       ];
   //       $this->view('pages/about',$data);
   //    }
}