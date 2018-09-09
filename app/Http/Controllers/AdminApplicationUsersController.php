<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminApplicationUsersController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "username";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = true;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon_text";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = false;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = true;
			$this->button_export = true;
			$this->table = "application_users";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"رقم العضو","name"=>"id"];
			$this->col[] = ["label"=>"اسم المستخدم","name"=>"username"];
			$this->col[] = ["label"=>"الاسم","name"=>"name"];
			$this->col[] = ["label"=>"الجنس","name"=>"(SELECT `cats`.`title` FROM cats WHERE  `cats`.`value` = gender AND `cats`.`key` = 'GENDER' ) as gender"];
			$this->col[] = ["label"=>"الدولة","name"=>"(SELECT `countries`.`native_name` FROM countries where `countries`.`code` =country_code) as country_code"];
			$this->col[] = ["label"=>"الصورة","name"=>"image","image"=>true];
            $this->col[] = ["label"=>"الحالة","name"=>"(SELECT `cats`.`title` FROM cats where `cats`.`value` = `application_users`.`status` and `cats`.`key` = 'APPLICATION_USER') as status"];

            # END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'اسم المستخدم','name'=>'username','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'الاسم','name'=>'name','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'فضلا ادخل احرف فقط'];
			$this->form[] = ['label'=>'البريد الالكتروني','name'=>'email','type'=>'email','validation'=>'required|min:1|max:255|email|unique:application_users','width'=>'col-sm-10','placeholder'=>'أدخل البريد الالكتروني'];
			$this->form[] = ['label'=>'رقم الجوال','name'=>'mobile','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
            $this->form[] = ['label'=>'الجنس','name'=>'gender','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataquery'=>'SELECT `cats`.`title` AS label , `cats`.`value` AS `value` FROM `cats` WHERE `cats`.`key` = \'GENDER\' ORDER BY `cats`.`id` ASC'];
            $this->form[] = ['label'=>'الدولة','name'=>'country_code','type'=>'select2','datatable'=>'countries,ar_name','datatable_where'=>'status != \'0\'','width'=>'col-sm-10'];
            $this->form[] = ['label'=>'العمر','name'=>'age_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataquery'=>'SELECT `ages`.`value` as label,`ages`.`id` as value FROM `ages` '];
            $this->form[] = ['label'=>'الهدف','name'=>'registration_aim_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataquery'=>'SELECT `registration_aims`.`value` as label , `registration_aims`.`id` as value FROM `registration_aims` '];
            $this->form[] = ['label'=>'كلمة المرور','name'=>'password','type'=>'password','validation'=>'min:6|max:32','width'=>'col-sm-10','help'=>'لا تتركه فارغا 6 احرف فما فوق'];
            $this->form[] = ['label'=>'الجنسية','name'=>'nationality_code','type'=>'select2','datatable'=>'nationalities,ar_name','datatable_where'=>'status != \'0\'','width'=>'col-sm-10'];
            $this->form[] = ['label'=>'طرق التواصل','name'=>'communication_way_ids','type'=>'checkbox','datatable'=>'communication_ways,value'];
            $this->form[] = ['label'=>'الحالة الاجتماعية','name'=>'social_status_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataquery'=>'SELECT `social_statuses`.`value` as label,`social_statuses`.`id` as value  FROM `social_statuses` '];
            $this->form[] = ['label'=>'لديه أبناء','name'=>'have_sons','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataquery'=>'SELECT `cats`.`title` AS label , `cats`.`value` AS `value` FROM `cats` WHERE `cats`.`key` = \'HAVE_SONS\' ORDER BY `cats`.`id` ASC'];
            $this->form[] = ['label'=>'التحصيل العلمي','name'=>'educational_qualification_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataquery'=>'SELECT `educational_qualifications`.`value` as label,`educational_qualifications`.`id` as value FROM `educational_qualifications` '];
            $this->form[] = ['label'=>'المهنة','name'=>'occupation_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataquery'=>'SELECT `occupations`.`value` as label ,`occupations`.`id` as value FROM `occupations`'];
            $this->form[] = ['label'=>'لون العين','name'=>'eye_color_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataquery'=>'SELECT `eye_colors`.`value` as label , `eye_colors`.`id` as value  FROM `eye_colors` '];
            $this->form[] = ['label'=>'لون البشرة','name'=>'skin_color_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataquery'=>'SELECT `skin_colors`.`value` as label,`skin_colors`.`id` as value FROM `skin_colors`'];
            $this->form[] = ['label'=>'لون الشعر','name'=>'hair_color_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataquery'=>'SELECT `hair_colors`.`value` as label , `hair_colors`.`id` as value FROM `hair_colors`'];
            $this->form[] = ['label'=>'الطول','name'=>'length_category_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataquery'=>'SELECT `length_categories`.`value` as label , `length_categories`.`id` as value FROM `length_categories`'];
            $this->form[] = ['label'=>'الوزن','name'=>'weight_category_id','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataquery'=>'SELECT `weight_categories`.`value` as label , `weight_categories`.`id` as value FROM `weight_categories`'];
			$this->form[] = ['label'=>'تحدث عن نفسك','name'=>'biography','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'تحدث عن الذي تبحث عنه','name'=>'partner_biography','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'الصورة الشخصية','name'=>'image','type'=>'upload','validation'=>'required|image|max:3000','width'=>'col-sm-10','help'=>'الملفات المدعومة : JPG, JPEG, PNG, GIF, BMP'];
            $this->form[] = ['label'=>'الحالة','name'=>'status','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataquery'=>'SELECT `cats`.`title` AS label , `cats`.`value` AS `value` FROM `cats` WHERE `cats`.`key` = \'APPLICATION_USER\' ORDER BY `cats`.`id` ASC'];

            $columns[] = ['label'=>'الصورة','name'=>'image','type'=>'upload','required'=>true,'validation'=>'required|image|max:3000'];
            $this->form[] = ['label'=>'الصور الإضافية','name'=>'application_user_images','type'=>'child','columns'=>$columns,'table'=>'application_user_images','foreign_key'=>'application_user_id'];

			# END FORM DO NOT REMOVE THIS LINE


			/*
	        | ----------------------------------------------------------------------
	        | Sub Module
	        | ----------------------------------------------------------------------
			| @label          = Label of action
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        |
	        */
	        $this->sub_module = array();
            $this->sub_module[] = ['label'=>'صور العضو','path'=>'application_user_images','parent_columns'=>'id','foreign_key'=>'application_user_id','button_color'=>'info'];
            $this->sub_module[] = ['label'=>'المعجبون','path'=>'user_application_likes','parent_columns'=>'id','foreign_key'=>'user_id','button_color'=>'warning'];
            $this->sub_module[] = ['label'=>'الوارد','path'=>'convsersations','parent_columns'=>'id','foreign_key'=>'to_user_id','button_color'=>'success'];
            $this->sub_module[] = ['label'=>'الصادر','path'=>'convsersations','parent_columns'=>'id','foreign_key'=>'from_user_id','button_color'=>'warning'];
            $this->sub_module[] = ['label'=>'الزوار','path'=>'user_application_visitors','parent_columns'=>'id','foreign_key'=>'user_id','button_color'=>'info'];



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();
            $this->addaction[] = ['label'=>'حظر','url'=>CRUDBooster::mainpath('set-status/banded/[id]'),'icon'=>'fa fa-ban','color'=>'danger','showIf'=>"[status] != 'موقوف'",'confirmation' => true];
            $this->addaction[] = ['label'=>'تفعيل','url'=>CRUDBooster::mainpath('set-status/active/[id]'),'icon'=>'fa fa-check','color'=>'success','showIf'=>"[status] != 'مفعل'"];


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }

        public function getSetStatus($status,$id) {
            DB::table('application_users')->where('id',$id)->update(['status'=>$status]);

            //This will redirect back and gives a message
            CRUDBooster::redirect($_SERVER['HTTP_REFERER'],"تم تعديل الحالة بنجاح!","info");
        }



	    //By the way, you can still create your own method in here... :) 


	}