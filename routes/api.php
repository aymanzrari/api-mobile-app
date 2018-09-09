<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('forgetPassword', function (Request $request) {
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 9; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    $newPass = implode($pass); //turn the array into a string
    $input = $request->all();
    $email = $input['email'];
    $count = DB::table('application_users')->where(['email' => $email, 'deleted_at' => null])->count();
    
    if($count > 0 ){
       Mail::send('emails.pass', ['data'=> $newPass], function ($message) use ($email) {

        $message->from('info@huraa.co', 'تطبيق حوراء ');

        $message->to($email)->subject('تطبيق حوراء - استعادة كلمة المرور ');

    });
       
       DB::table('application_users')
       ->where(['email' => $email, 'deleted_at' => null])
       ->update(['password' => Hash::make($newPass)]);
       
       
       
       return response(array("status" => true, "message" => "تم إرسال كلمة المرور الجديدة على بريدك الالكتروني."), \Illuminate\Http\Response::HTTP_OK);
   }else{
      return response(array("status" => true, "message" => "عذرا هذا البريد غير مسجل لدينا."), \Illuminate\Http\Response::HTTP_OK);
  }
});



// All drop downs in the application are below

Route::prefix('dropdowns')->group(function () {
    Route::get('registrationAims', function () {
        $registrationAims = DB::table('registration_aims')->where(['status' => '1', 'deleted_at' => null])->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $registrationAims), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('ages', function () {
        $ages = DB::table('ages')->where(['status' => '1', 'deleted_at' => null])->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $ages), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('countries', function () {
        $countries = DB::table('countries')->where(['status' => '1', 'deleted_at' => null])->select('code as id', 'ar_name as value', 'flag_image')->orderBy('orderIn')->get();
        /**********************************
         * change image url
         **********************************/
        foreach ($countries as $country) {
            $country->flag_image = "http://awa.m-apps.co/uploads/flags/128x128/" . $country->flag_image;
        }
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $countries), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('nationalities', function () {
        $nationalities = DB::table('nationalities')->where(['status' => '1', 'deleted_at' => null])->select('code as id', 'ar_name as value', 'flag_image')->orderBy('orderIn')->get();
        /**********************************
         * change image url
         **********************************/
        foreach ($nationalities as $nationality) {
            $nationality->flag_image = "http://awa.m-apps.co/uploads/flags/128x128/" . $nationality->flag_image;
        }
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $nationalities), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('socialStatuses', function () {
        $social_statuses = DB::table('social_statuses')->where(['status' => '1', 'deleted_at' => null])->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $social_statuses), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('haveSons', function () {
        $haveSons = DB::table('cats')->where(['key' => 'HAVE_SONS', 'deleted_at' => null])->select('title as value', 'value as id')->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $haveSons), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('educationalQualifications', function () {
        $educationalQualifications = DB::table('educational_qualifications')->where(['status' => '1', 'deleted_at' => null])->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $educationalQualifications), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('occupations', function () {
        $occupations = DB::table('occupations')->where(['status' => '1', 'deleted_at' => null])->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $occupations), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('communicationWays', function () {
        $communicationWays = DB::table('communication_ways')->select('value')->where(['status' => '1', 'deleted_at' => null])->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $communicationWays), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('eyeColors', function () {
        $eyeColors = DB::table('eye_colors')->where(['status' => '1', 'deleted_at' => null])->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $eyeColors), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('skinColors', function () {
        $skinColors = DB::table('skin_colors')->where(['status' => '1', 'deleted_at' => null])->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $skinColors), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('hairColors', function () {
        $hairColors = DB::table('hair_colors')->where(['status' => '1', 'deleted_at' => null])->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $hairColors), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('lengthCategories', function () {
        $lengthCategories = DB::table('length_categories')->where(['status' => '1', 'deleted_at' => null])->orderBy('id')->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $lengthCategories), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('weightCategories', function () {
        $weightCategories = DB::table('weight_categories')->where(['status' => '1', 'deleted_at' => null])->orderBy('id')->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $weightCategories), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('adminConnectionSubjects', function () {
        $haveSons = DB::table('cats')->where(['key' => 'ADMIN_CONNECTION_TYPE', 'deleted_at' => null])->select('title as value', 'value as id')->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $haveSons), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('searchByDate', function () {
        $statics = array(
            array(
                "id" => 'today',
                "value" => 'اليوم'
            ),
            array(
                "id" => 'week',
                "value" => 'أسبوع'
            ),
            array(
                "id" => 'month',
                "value" => 'شهر'
            ),
            array(
                "id" => 'three_month',
                "value" => 'ثلاثة أشهر'
            ),
            array(
                "id" => 'year',
                "value" => 'سنة'
            )
        );
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $statics), \Illuminate\Http\Response::HTTP_OK);
    });


});

// all static pages and texts are here
Route::prefix('statics')->group(function () {
    Route::get('termsOfUse', function () {
        $termsOfUse = DB::table('application_static_pages')->where(['id' => 'rules', 'deleted_at' => null])->select('title', 'value')->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $termsOfUse), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('oath', function () {
        $oath = DB::table('application_static_pages')->where(['id' => 'oath', 'deleted_at' => null])->select('title', 'value')->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $oath), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('advicesAndSuggestions', function () {
        $advices = DB::table('application_static_pages')->where(['id' => 'advices', 'deleted_at' => null])->select('title', 'value')->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $advices), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('privacyAndPolicy', function () {
        $privacyAndPolicy = DB::table('application_static_pages')->where(['id' => 'privacy-policy', 'deleted_at' => null])->select('title', 'value')->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $privacyAndPolicy), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('safetyAlerts', function () {
        $safetyAlerts = DB::table('application_static_pages')->where(['id' => 'safety', 'deleted_at' => null])->select('title', 'value')->get();
        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $safetyAlerts), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::get('faqs', function () {
        $faqsDeps = DB::table('faqs_deps')->where(['deleted_at' => null])->select('id', 'title')->get();

        for ($i = 0; $i < sizeof($faqsDeps); $i++) {
            $faqsDeps[$i]->faqs = DB::table('faqs')->where(['deleted_at' => null, 'dep_id' => $faqsDeps[$i]->id])->select('question', 'answer')->get();
        }

        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $faqsDeps), \Illuminate\Http\Response::HTTP_OK);
    });
});

Route::prefix('user')->group(function () {
    Route::post('profile', function (Request $request) {
        $input = $request->all();
        $user['profile'] = DB::table('application_users')
        ->where('application_users.status', '<>', 'banded')
        ->where(['application_users.deleted_at' => null, 'application_users.id' => $input['id']])
        ->join('countries', 'application_users.country_code', '=', 'countries.code')
        ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
        ->select('application_users.*', 'countries.ar_name as country_name', 'registration_aims.value as registration_aim')
        ->get();
        $user['application_user_images'] = DB::table('application_user_images')
        ->where(['deleted_at' => null, 'application_user_id' => $input['id']])
        ->get();


        /**********************************
         * change image url
         **********************************/
        $user['profile'][0]->image = "http://awa.m-apps.co/" . $user['profile'][0]->image;
        foreach ($user['application_user_images'] as $userImage) {
            $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
        }

        if ($user['profile'][0]->isPay != 0) {
            $user['profile'][0]->subscription_id = DB::table('banks_transfers')
            ->where(['deleted_at' => null, 'user_id' => $input['id']])
            ->first()->subscription_id;
        } else{
            $user['profile'][0]->subscription_id = 3;
        }


        if ($user['profile'][0]->nationality_code != null) {
            $user['profile'][0]->nationality_name = DB::table('nationalities')
            ->where(['deleted_at' => null, 'code' => $user['profile'][0]->nationality_code])
            ->select('nationalities.ar_name as nationality_name')
            ->first()->nationality_name;
        } else {
            $user['profile'][0]->nationality_name = null;
        }

        if ($user['profile'][0]->age_id != null) {
            $user['profile'][0]->age = DB::table('ages')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->age_id])
            ->select('ages.value as age')
            ->first()->age;
        } else {
            $user['profile'][0]->age = null;
        }

        if ($user['profile'][0]->educational_qualification_id != null) {
            $user['profile'][0]->educational_qualification = DB::table('educational_qualifications')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->educational_qualification_id])
            ->select('educational_qualifications.value as educational_qualification')
            ->first()->educational_qualification;
        } else {
            $user['profile'][0]->educational_qualification = null;
        }

        if ($user['profile'][0]->eye_color_id != null) {
            $user['profile'][0]->eye_color = DB::table('eye_colors')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->eye_color_id])
            ->select('eye_colors.value as eye_color')
            ->first()->eye_color;
        } else {
            $user['profile'][0]->eye_color = null;
        }

        if ($user['profile'][0]->skin_color_id != null) {
            $user['profile'][0]->skin_color = DB::table('skin_colors')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->skin_color_id])
            ->select('skin_colors.value as skin_color')
            ->first()->skin_color;
        } else {
            $user['profile'][0]->skin_color = null;
        }

        if ($user['profile'][0]->hair_color_id != null) {
            $user['profile'][0]->hair_color = DB::table('hair_colors')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->hair_color_id])
            ->select('hair_colors.value as hair_color')
            ->first()->hair_color;
        } else {
            $user['profile'][0]->hair_color = null;
        }


        if ($user['profile'][0]->social_status_id != null) {
            $user['profile'][0]->social_status = DB::table('social_statuses')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->social_status_id])
            ->select('social_statuses.value as social_status')
            ->first()->social_status;
        } else {
            $user['profile'][0]->social_status = null;
        }

        if ($user['profile'][0]->occupation_id != null) {
            $user['profile'][0]->occupation = DB::table('occupations')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->occupation_id])
            ->select('occupations.value as occupation')
            ->first()->occupation;
        } else {
            $user['profile'][0]->occupation = null;
        }

        if ($user['profile'][0]->length_category_id != null) {
            $user['profile'][0]->length_category = DB::table('length_categories')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->length_category_id])
            ->select('length_categories.value as length_category')
            ->first()->length_category;
        } else {
            $user['profile'][0]->length_category = null;
        }

        if ($user['profile'][0]->weight_category_id != null) {
            $user['profile'][0]->weight_category = DB::table('weight_categories')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->weight_category_id])
            ->select('weight_categories.value as weight_category')
            ->first()->weight_category;
        } else {
            $user['profile'][0]->weight_category = null;
        }

        if ($user['profile'][0]->gender == 'male') {
            $user['profile'][0]->gender_title = "ذكر";
        } else {
            $user['profile'][0]->gender_title = "أنثى";
        }

        $Conversations = DB::table('convsersations')
        ->where(['convsersations.to_user_id' => $input['id']])
        ->orWhere(['convsersations.from_user_id' => $input['id']])
        ->get();
        $MessagesCount = 0;
        for ($i = 0; $i < sizeof($Conversations); $i++) {
            if ($Conversations[$i]->deleted_at == null) {

                $ConversationDetails = DB::table('conversation_info')
                ->where('conversation_info.from_id', '<>', $input['id'])
                ->where(['conversation_info.deleted_at' => null])
                ->where(['conversation_info.seen_to' => null])
                ->where(['conversation_info.conversation_id' => $Conversations[$i]->id])
                ->get();
                if (sizeof($ConversationDetails) > 0) {
                    $MessagesCount = $MessagesCount + sizeof($ConversationDetails);
                }
            }

        }
        $user['profile'][0]->new_messsages_count = $MessagesCount;

        $user['profile'][0]->new_likes_count = DB::table('user_application_likes')
        ->where(['user_application_likes.deleted_at' => null, 'user_application_likes.seen_at' => null, 'user_application_likes.user_id' => $input['id']])
        ->count();
        $user['profile'][0]->new_visitors_count = DB::table('user_application_visitors')
        ->where(['user_application_visitors.deleted_at' => null, 'user_application_visitors.seen_at' => null, 'user_application_visitors.user_id' => $input['id']])
        ->count();

        DB::table('application_users')
        ->where('id', $input['id'])
        ->update(['last_seen' => Carbon::now()->toDateTimeString()]);


        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $user), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::post('updateBiography', function (Request $request) {
        $success = false;
        $data = null;
        $message = "تم تحديث البيانات بنجاح.";
        $input = $request->all();

        $validator = Validator::make($request->all(), [
            'user_id' => ['required', Rule::exists('application_users', 'id')],
            'biography' => 'nullable|min:30',
            'partner_biography' => 'nullable|min:30'
        ]
        , [
            'user_id.required' => 'حقل رقم المستخدم حقل مطلوب',
            'user_id.exists' => 'حقل رقم المستخدم المدخل غير موجود',
            'biography.min' => 'تحدث عن نفسك تتكون على الأقل من 30 حرف',
            'partner_biography.min' => 'تحدث عن شريكك تتكون على الأقل من 30 حرف'
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
        } else {
            $success = true;

            $insertArray = array();

            if (!empty($input['biography'])) {
                $insertArray['biography'] = $input['biography'];
            }

            if (!empty($input['partner_biography'])) {
                $insertArray['partner_biography'] = $input['partner_biography'];
            }


            DB::table('application_users')
            ->where('id', $input['user_id'])
            ->update(
                $insertArray
            );
            $id = $input['user_id'];

            $user['profile'] = DB::table('application_users')
            ->where('application_users.status', '<>', 'banded')
            ->where(['application_users.deleted_at' => null, 'application_users.id' => $id])
            ->join('countries', 'application_users.country_code', '=', 'countries.code')
            ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
            ->select('application_users.*', 'countries.ar_name as country_name', 'registration_aims.value as registration_aim')
            ->get();
            $user['application_user_images'] = DB::table('application_user_images')
            ->where(['deleted_at' => null, 'application_user_id' => $id])
            ->get();

                    /**********************************
                     * change image url
                     **********************************/
                    $user['profile'][0]->image = "http://awa.m-apps.co/" . $user['profile'][0]->image;
                    foreach ($user['application_user_images'] as $userImage) {
                        $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
                    }

                    if ($user['profile'][0]->nationality_code != null) {
                        $user['profile'][0]->nationality_name = DB::table('nationalities')
                        ->where(['deleted_at' => null, 'code' => $user['profile'][0]->nationality_code])
                        ->select('nationalities.ar_name as nationality_name')
                        ->first()->nationality_name;
                    } else {
                        $user['profile'][0]->nationality_name = null;
                    }

                    if ($user['profile'][0]->age_id != null) {
                        $user['profile'][0]->age = DB::table('ages')
                        ->where(['deleted_at' => null, 'id' => $user['profile'][0]->age_id])
                        ->select('ages.value as age')
                        ->first()->age;
                    } else {
                        $user['profile'][0]->age = null;
                    }

                    if ($user['profile'][0]->educational_qualification_id != null) {
                        $user['profile'][0]->educational_qualification = DB::table('educational_qualifications')
                        ->where(['deleted_at' => null, 'id' => $user['profile'][0]->educational_qualification_id])
                        ->select('educational_qualifications.value as educational_qualification')
                        ->first()->educational_qualification;
                    } else {
                        $user['profile'][0]->educational_qualification = null;
                    }

                    if ($user['profile'][0]->eye_color_id != null) {
                        $user['profile'][0]->eye_color = DB::table('eye_colors')
                        ->where(['deleted_at' => null, 'id' => $user['profile'][0]->eye_color_id])
                        ->select('eye_colors.value as eye_color')
                        ->first()->eye_color;
                    } else {
                        $user['profile'][0]->eye_color = null;
                    }

                    if ($user['profile'][0]->skin_color_id != null) {
                        $user['profile'][0]->skin_color = DB::table('skin_colors')
                        ->where(['deleted_at' => null, 'id' => $user['profile'][0]->skin_color_id])
                        ->select('skin_colors.value as skin_color')
                        ->first()->skin_color;
                    } else {
                        $user['profile'][0]->skin_color = null;
                    }

                    if ($user['profile'][0]->hair_color_id != null) {
                        $user['profile'][0]->hair_color = DB::table('hair_colors')
                        ->where(['deleted_at' => null, 'id' => $user['profile'][0]->hair_color_id])
                        ->select('hair_colors.value as hair_color')
                        ->first()->hair_color;
                    } else {
                        $user['profile'][0]->hair_color = null;
                    }


                    if ($user['profile'][0]->social_status_id != null) {
                        $user['profile'][0]->social_status = DB::table('social_statuses')
                        ->where(['deleted_at' => null, 'id' => $user['profile'][0]->social_status_id])
                        ->select('social_statuses.value as social_status')
                        ->first()->social_status;
                    } else {
                        $user['profile'][0]->social_status = null;
                    }

                    if ($user['profile'][0]->occupation_id != null) {
                        $user['profile'][0]->occupation = DB::table('occupations')
                        ->where(['deleted_at' => null, 'id' => $user['profile'][0]->occupation_id])
                        ->select('occupations.value as occupation')
                        ->first()->occupation;
                    } else {
                        $user['profile'][0]->occupation = null;
                    }

                    if ($user['profile'][0]->length_category_id != null) {
                        $user['profile'][0]->length_category = DB::table('length_categories')
                        ->where(['deleted_at' => null, 'id' => $user['profile'][0]->length_category_id])
                        ->select('length_categories.value as length_category')
                        ->first()->length_category;
                    } else {
                        $user['profile'][0]->length_category = null;
                    }

                    if ($user['profile'][0]->weight_category_id != null) {
                        $user['profile'][0]->weight_category = DB::table('weight_categories')
                        ->where(['deleted_at' => null, 'id' => $user['profile'][0]->weight_category_id])
                        ->select('weight_categories.value as weight_category')
                        ->first()->weight_category;
                    } else {
                        $user['profile'][0]->weight_category = null;
                    }

                    if ($user['profile'][0]->gender == 'male') {
                        $user['profile'][0]->gender_title = "ذكر";
                    } else {
                        $user['profile'][0]->gender_title = "أنثى";
                    }

                    $Conversations = DB::table('convsersations')
                    ->where(['convsersations.to_user_id' => $input['user_id']])
                    ->orWhere(['convsersations.from_user_id' => $input['user_id']])
                    ->get();
                    $MessagesCount = 0;
                    for ($i = 0; $i < sizeof($Conversations); $i++) {
                        if ($Conversations[$i]->deleted_at == null) {

                            $ConversationDetails = DB::table('conversation_info')
                            ->where('conversation_info.from_id', '<>', $input['user_id'])
                            ->where(['conversation_info.deleted_at' => null])
                            ->where(['conversation_info.seen_to' => null])
                            ->where(['conversation_info.conversation_id' => $Conversations[$i]->id])
                            ->get();
                            if (sizeof($ConversationDetails) > 0) {
                                $MessagesCount = $MessagesCount + sizeof($ConversationDetails);
                            }
                        }

                    }
                    $user['profile'][0]->new_messsages_count = $MessagesCount;

                    $user['profile'][0]->new_likes_count = DB::table('user_application_likes')
                    ->where(['user_application_likes.deleted_at' => null, 'user_application_likes.seen_at' => null, 'user_application_likes.user_id' => $input['user_id']])
                    ->count();
                    $user['profile'][0]->new_visitors_count = DB::table('user_application_visitors')
                    ->where(['user_application_visitors.deleted_at' => null, 'user_application_visitors.seen_at' => null, 'user_application_visitors.user_id' => $input['user_id']])
                    ->count();


                    $data = $user;

                }

                DB::table('application_users')
                ->where('id', $input['user_id'])
                ->update(['last_seen' => Carbon::now()->toDateTimeString()]);

                return response(array("status" => $success, "message" => $message, "data" => $data), \Illuminate\Http\Response::HTTP_OK);

            });

    Route::post('inboxConversations', function (Request $request) {
        $input = $request->all();
        $inboxConversations = DB::table('convsersations')->where(['convsersations.to_user_id' => $input['user_id'], 'convsersations.deleted_at' => null])
        ->join('application_users', 'convsersations.from_user_id', '=', 'application_users.id')
        ->select('convsersations.*', 'application_users.name as from_user_name',
            'application_users.username as from_user_username',
            'application_users.image as from_user_image')
        ->get();
        for($i=0; $i<sizeof($inboxConversations) ;$i++){
            if (sizeof($inboxConversations) != 0) {
                $lastConversation = DB::table('conversation_info')->where(['conversation_info.conversation_id' => $inboxConversations[$i]->id, 'conversation_info.deleted_at' => null])
                ->select('conversation_info.message as last_message', 'conversation_info.created_at as last_message_time')
                ->orderBy('conversation_info.created_at', 'desc')
                ->limit(1)
                ->get();
                if (sizeof($lastConversation) != 0) {
                    $inboxConversations[$i]->last_message = $lastConversation[0]->last_message;
                    $inboxConversations[$i]->last_message_time = $lastConversation[0]->last_message_time;
                }
            }
        }

            /**********************************
             * change image url
             **********************************/
            if (sizeof($inboxConversations) != 0) {
                for($i=0; $i<sizeof($inboxConversations) ;$i++){
                    $inboxConversations[$i]->from_user_image = "http://awa.m-apps.co/" . $inboxConversations[$i]->from_user_image;
                }
            }
            DB::table('application_users')
            ->where('id', $input['user_id'])
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);
            return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $inboxConversations), \Illuminate\Http\Response::HTTP_OK);
        });

    Route::post('sentConversations', function (Request $request) {
        $input = $request->all();
        $sentConversations = DB::table('convsersations')->where(['convsersations.from_user_id' => $input['user_id'], 'convsersations.deleted_at' => null])
        ->join('application_users', 'convsersations.to_user_id', '=', 'application_users.id')
        ->select('convsersations.*', 'application_users.name as to_user_name',
            'application_users.username as to_user_username',
            'application_users.image as to_user_image')
        ->get();
        if (sizeof($sentConversations) != 0) {

            for($i=0; $i<sizeof($sentConversations) ;$i++){
                $lastConversation = DB::table('conversation_info')->where(['conversation_info.conversation_id' => $sentConversations[$i]->id, 'conversation_info.deleted_at' => null])
                ->select('conversation_info.message as last_message', 'conversation_info.created_at as last_message_time')
                ->orderBy('conversation_info.created_at', 'desc')
                ->limit(1)
                ->get();
                $sentConversations[$i]->last_message = $lastConversation[0]->last_message;
                $sentConversations[$i]->last_message_time = $lastConversation[0]->last_message_time;
            }

        }
            /**********************************
             * change image url
             **********************************/
            if (sizeof($sentConversations) != 0) {
                for($i=0; $i<sizeof($sentConversations) ;$i++){
                    $sentConversations[$i]->to_user_image = "http://awa.m-apps.co/" . $sentConversations[$i]->to_user_image;
                }
            }

            DB::table('application_users')
            ->where('id', $input['user_id'])
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);
            return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $sentConversations), \Illuminate\Http\Response::HTTP_OK);
        });

    Route::post('conversationDetails', function (Request $request) {
        $input = $request->all();
        $ConversationDetails = DB::table('conversation_info')
        ->where(['conversation_info.deleted_at' => null])
        ->where(['conversation_info.conversation_id' => $input['conversation_id']])
        ->get();

        $Conversation = DB::table('convsersations')->where(['convsersations.deleted_at' => null])->where(['convsersations.id' => $input['conversation_id']])
        ->get();
        
        if ($Conversation[0]->from_user_id == $input['user_id']) {
          
            $insertArray = array(
                'seen_from' => Carbon::now()->toDateTimeString()
            );
            DB::table('conversation_info')
            ->where('conversation_id', $input['conversation_id'])
            ->where(['seen_from' => NULL])
            ->update(
                $insertArray
            );
            
        } else if ($Conversation[0]->to_user_id == $input['user_id']) {

            $insertArray = array(
                'seen_to' => Carbon::now()->toDateTimeString()
            );
            DB::table('conversation_info')
            ->where('conversation_id', $input['conversation_id'])
            ->whereNull('seen_to')
            ->update(
                $insertArray
            );
        }



        return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $ConversationDetails), \Illuminate\Http\Response::HTTP_OK);
    });

    Route::post('sendMessage', function (Request $request) {
        $input = $request->all();
        $insertArray = array('conversation_id' => $input['conversation_id'],
            'message' => $input['message'],
            'from_id' => $input['user_id']);
        $id = DB::table('conversation_info')->insertGetId(
            $insertArray
        );
        $ConversationDetails = DB::table('conversation_info')
        ->where(['conversation_info.deleted_at' => null])
        ->where(['conversation_info.conversation_id' => $input['conversation_id']])
        ->get();
        $MessageDetails = DB::table('conversation_info')
        ->where(['conversation_info.deleted_at' => null])
        ->where(['conversation_info.conversation_id' => $input['conversation_id']])
        ->where(['conversation_info.id' => $id])
        ->first();
        $MessageDetails->username = DB::table('application_users')->select('id', 'firebase_token', 'device_type', 'username')->where('id', '=', $input['user_id'])->first()->username;
        $Conversation = DB::table('convsersations')->where(['convsersations.deleted_at' => null])
        ->get();
        if (sizeof($Conversation) == 1) {
            if ($Conversation[0]->from_user_id == $input['user_id']) {

                $insertArray = array(
                    'seen_from' => Carbon::now()->toDateTimeString()
                );
                DB::table('conversation_info')
                ->where('conversation_id', $input['conversation_id'])
                ->where(['seen_from' => null])
                ->update(
                    $insertArray
                );
            } else if ($Conversation[0]->to_user_id == $input['user_id']) {
                $insertArray = array(
                    'seen_to' => Carbon::now()->toDateTimeString()
                );
                DB::table('conversation_info')
                ->where('conversation_id', $input['conversation_id'])
                ->where(['seen_to' => null])
                ->update(
                    $insertArray
                );
            }

                ////////////////////////
                ///  Send Notification /
                /// /////////////////////
            if ($Conversation[0]->to_user_id == $input['user_id']) {
                $toUserId = $Conversation[0]->from_user_id;
            } else {
                $toUserId = $Conversation[0]->to_user_id;
            }
            $SendUser = DB::table('application_users')->select('id', 'firebase_token', 'device_type', 'username')->where('id', '=', $input['user_id'])->first();
            $users = DB::table('application_users')->select('id', 'firebase_token', 'device_type', 'username')->where('id', '=', $toUserId)->get();

            foreach ($users as $user) {
                $message = "لديك رسالة جديدة من " . $SendUser->username;
                $appName = "حوراء";
                DB::table('application_users_notifications')->insert(
                    ['user_id' => $user->id, 'content' => $message, 'type' => 'message', 'details' => $Conversation[0]->id]
                );

                if ($user->firebase_token != NULL && $user->firebase_token != "NULL" && $user->firebase_token != "") {
                    if ($user->device_type != NULL && $user->device_type != "NULL" && $user->device_type != "") {
                        if ($user->device_type == "android") {
                            $url = 'https://fcm.googleapis.com/fcm/send';
                            $data = array(
                                'notification' => array(
                                    'alert' => array(
                                        'title' => $appName,
                                        'body' => $message,
                                        'sound' => 'default'
                                    )
                                ),
                                'message' => $message,
                                'username' => $MessageDetails->username,
                                'new_message' => $MessageDetails->message,
                                'new_message_time' => $MessageDetails->created_at,
                                'new_message_user_id' => $MessageDetails->from_id,
                            );
                            $fields = array(
                                'data' => $data,
                                'to' => $user->firebase_token
                            );
                            $headers = array(
                                'Authorization:key=AIzaSyB7YjkicaSIjXs8rslJpxN3rhYpOjysB6A',
                                'Content-Type: application/json'
                            );

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                            $result = curl_exec($ch);
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                            curl_close($ch);
                        }
                    }
                }
            }


                ////////////////////////////////
                ///  End Send Notification
                /// ///////////////////////////


        }

        return response(array("status" => true, "message" => "تم الارسال بنجاح", "data" => $ConversationDetails), \Illuminate\Http\Response::HTTP_OK);

    });

    Route::post('sendDirectMessage', function (Request $request) {
        $input = $request->all();
        $Conversation = DB::table('convsersations')->where(['convsersations.deleted_at' => null,'from_user_id'=>$input['user_id'],'to_user_id'=>$input['to_user_id']])
        ->get();
        if (sizeof($Conversation) == 1) {
            $convsersationId = DB::table('convsersations')->where(['convsersations.deleted_at' => null,'from_user_id'=>$input['user_id'],'to_user_id'=>$input['to_user_id']])->first()->id;
            $insertArray = array('conversation_id' => $convsersationId,
                'message' => $input['message'],
                'from_id' => $input['user_id']);
            $id = DB::table('conversation_info')->insertGetId(
                $insertArray
            );

        } else {
            $insertArray = array(
                'from_user_id' => $input['user_id'],
                'to_user_id' => $input['to_user_id']);
            $convsersationId = DB::table('convsersations')->insertGetId(
                $insertArray
            );

            $insertArray = array('conversation_id' => $convsersationId,
                'message' => $input['message'],
                'from_id' => $input['user_id']);
            $id = DB::table('conversation_info')->insertGetId(
                $insertArray
            );


        }


        $ConversationDetails = DB::table('conversation_info')
        ->where(['conversation_info.deleted_at' => null])
        ->where(['conversation_info.conversation_id' => $convsersationId])
        ->get();
        $MessageDetails = DB::table('conversation_info')
        ->where(['conversation_info.deleted_at' => null])
        ->where(['conversation_info.conversation_id' => $convsersationId])
        ->where(['conversation_info.id' => $id])
        ->first();
        $MessageDetails->username = DB::table('application_users')->select('id', 'firebase_token', 'device_type', 'username')->where('id', '=', $input['user_id'])->first()->username;
        $Conversation = DB::table('convsersations')->where(['convsersations.deleted_at' => null])
        ->get();
        if (sizeof($Conversation) == 1) {
            if ($Conversation[0]->from_user_id == $input['user_id']) {

                $insertArray = array(
                    'seen_from' => Carbon::now()->toDateTimeString()
                );
                DB::table('conversation_info')
                ->where('conversation_id', $convsersationId)
                ->where(['seen_from' => null])
                ->update(
                    $insertArray
                );
            } else if ($Conversation[0]->to_user_id == $input['user_id']) {
                $insertArray = array(
                    'seen_to' => Carbon::now()->toDateTimeString()
                );
                DB::table('conversation_info')
                ->where('conversation_id', $convsersationId)
                ->where(['seen_to' => null])
                ->update(
                    $insertArray
                );
            }

                ////////////////////////
                ///  Send Notification /
                /// /////////////////////
            if ($Conversation[0]->to_user_id == $input['user_id']) {
                $toUserId = $Conversation[0]->from_user_id;
            } else {
                $toUserId = $Conversation[0]->to_user_id;
            }
            $SendUser = DB::table('application_users')->select('id', 'firebase_token', 'device_type', 'username')->where('id', '=', $input['user_id'])->first();
            $users = DB::table('application_users')->select('id', 'firebase_token', 'device_type', 'username')->where('id', '=', $toUserId)->get();

            foreach ($users as $user) {
                $message = "لديك رسالة جديدة من " . $SendUser->username;
                $appName = "حوراء";
                DB::table('application_users_notifications')->insert(
                    ['user_id' => $user->id, 'content' => $message, 'type' => 'message', 'details' => $Conversation[0]->id]
                );

                if ($user->firebase_token != NULL && $user->firebase_token != "NULL" && $user->firebase_token != "") {
                    if ($user->device_type != NULL && $user->device_type != "NULL" && $user->device_type != "") {
                        if ($user->device_type == "android") {
                            $url = 'https://fcm.googleapis.com/fcm/send';
                            $data = array(
                                'notification' => array(
                                    'alert' => array(
                                        'title' => $appName,
                                        'body' => $message,
                                        'sound' => 'default'
                                    )
                                ),
                                'message' => $message,
                                'username' => $MessageDetails->username,
                                'new_message' => $MessageDetails->message,
                                'new_message_time' => $MessageDetails->created_at,
                                'new_message_user_id' => $MessageDetails->from_id,
                            );
                            $fields = array(
                                'data' => $data,
                                'to' => $user->firebase_token
                            );
                            $headers = array(
                                'Authorization:key=AIzaSyB7YjkicaSIjXs8rslJpxN3rhYpOjysB6A',
                                'Content-Type: application/json'
                            );

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                            $result = curl_exec($ch);
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                            curl_close($ch);
                        }
                    }
                }
            }


                ////////////////////////////////
                ///  End Send Notification
                /// ///////////////////////////


        }

        return response(array("status" => true, "message" => "تم الارسال بنجاح", "data" => $ConversationDetails), \Illuminate\Http\Response::HTTP_OK);

    });

    Route::post('likes', function (Request $request) {
        $input = $request->all();
        $likes = DB::table('user_application_likes')
        ->where(['user_application_likes.deleted_at' => null, 'user_application_likes.user_id' => $input['user_id']])
        ->join('application_users', 'user_application_likes.from_user_id', '=', 'application_users.id')
        ->select('user_application_likes.from_user_id as user_id', 'user_application_likes.created_at', 'application_users.name', 'application_users.username', 'application_users.image')->get();

            /**********************************
             * change image url
             **********************************/
            if (sizeof($likes) != 0) {
                $likes[0]->image = "http://awa.m-apps.co/" . $likes[0]->image;
            }

            /////////////////////
            for ($u = 0; $u < sizeof($likes); $u++) {
                $user['profile'] = DB::table('application_users')
                ->where('application_users.status', '<>', 'banded')
                ->where(['application_users.deleted_at' => null, 'application_users.id' => $likes[$u]->user_id])
                ->join('countries', 'application_users.country_code', '=', 'countries.code')
                ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
                ->select('application_users.*', 'countries.ar_name as country_name', 'registration_aims.value as registration_aim')
                ->get();
                $user['application_user_images'] = DB::table('application_user_images')
                ->where(['deleted_at' => null, 'application_user_id' => $likes[$u]->user_id])
                ->get();


                /**********************************
                 * change image url
                 **********************************/
                $user['profile'][0]->image = "http://awa.m-apps.co/" . $user['profile'][0]->image;
                foreach ($user['application_user_images'] as $userImage) {
                    $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
                }

                if ($user['profile'][0]->nationality_code != null) {
                    $user['profile'][0]->nationality_name = DB::table('nationalities')
                    ->where(['deleted_at' => null, 'code' => $user['profile'][0]->nationality_code])
                    ->select('nationalities.ar_name as nationality_name')
                    ->first()->nationality_name;
                } else {
                    $user['profile'][0]->nationality_name = null;
                }

                if ($user['profile'][0]->age_id != null) {
                    $user['profile'][0]->age = DB::table('ages')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->age_id])
                    ->select('ages.value as age')
                    ->first()->age;
                } else {
                    $user['profile'][0]->age = null;
                }

                if ($user['profile'][0]->educational_qualification_id != null) {
                    $user['profile'][0]->educational_qualification = DB::table('educational_qualifications')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->educational_qualification_id])
                    ->select('educational_qualifications.value as educational_qualification')
                    ->first()->educational_qualification;
                } else {
                    $user['profile'][0]->educational_qualification = null;
                }

                if ($user['profile'][0]->eye_color_id != null) {
                    $user['profile'][0]->eye_color = DB::table('eye_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->eye_color_id])
                    ->select('eye_colors.value as eye_color')
                    ->first()->eye_color;
                } else {
                    $user['profile'][0]->eye_color = null;
                }

                if ($user['profile'][0]->skin_color_id != null) {
                    $user['profile'][0]->skin_color = DB::table('skin_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->skin_color_id])
                    ->select('skin_colors.value as skin_color')
                    ->first()->skin_color;
                } else {
                    $user['profile'][0]->skin_color = null;
                }

                if ($user['profile'][0]->hair_color_id != null) {
                    $user['profile'][0]->hair_color = DB::table('hair_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->hair_color_id])
                    ->select('hair_colors.value as hair_color')
                    ->first()->hair_color;
                } else {
                    $user['profile'][0]->hair_color = null;
                }


                if ($user['profile'][0]->social_status_id != null) {
                    $user['profile'][0]->social_status = DB::table('social_statuses')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->social_status_id])
                    ->select('social_statuses.value as social_status')
                    ->first()->social_status;
                } else {
                    $user['profile'][0]->social_status = null;
                }

                if ($user['profile'][0]->occupation_id != null) {
                    $user['profile'][0]->occupation = DB::table('occupations')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->occupation_id])
                    ->select('occupations.value as occupation')
                    ->first()->occupation;
                } else {
                    $user['profile'][0]->occupation = null;
                }

                if ($user['profile'][0]->length_category_id != null) {
                    $user['profile'][0]->length_category = DB::table('length_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->length_category_id])
                    ->select('length_categories.value as length_category')
                    ->first()->length_category;
                } else {
                    $user['profile'][0]->length_category = null;
                }

                if ($user['profile'][0]->weight_category_id != null) {
                    $user['profile'][0]->weight_category = DB::table('weight_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->weight_category_id])
                    ->select('weight_categories.value as weight_category')
                    ->first()->weight_category;
                } else {
                    $user['profile'][0]->weight_category = null;
                }

                if ($user['profile'][0]->gender == 'male') {
                    $user['profile'][0]->gender_title = "ذكر";
                } else {
                    $user['profile'][0]->gender_title = "أنثى";
                }

                $Conversations = DB::table('convsersations')
                ->where(['convsersations.to_user_id' => $input['id']])
                ->orWhere(['convsersations.from_user_id' => $input['id']])
                ->get();
                $MessagesCount = 0;
                for ($i = 0; $i < sizeof($Conversations); $i++) {
                    if ($Conversations[$i]->deleted_at == null) {

                        $ConversationDetails = DB::table('conversation_info')
                        ->where('conversation_info.from_id', '<>', $input['id'])
                        ->where(['conversation_info.deleted_at' => null])
                        ->where(['conversation_info.seen_to' => null])
                        ->where(['conversation_info.conversation_id' => $Conversations[$i]->id])
                        ->get();
                        if (sizeof($ConversationDetails) > 0) {
                            $MessagesCount = $MessagesCount + sizeof($ConversationDetails);
                        }
                    }

                }
                $user['profile'][0]->new_messsages_count = $MessagesCount;

                $user['profile'][0]->new_likes_count = DB::table('user_application_likes')
                ->where(['user_application_likes.deleted_at' => null, 'user_application_likes.seen_at' => null, 'user_application_likes.user_id' => $input['id']])
                ->count();
                $user['profile'][0]->new_visitors_count = DB::table('user_application_visitors')
                ->where(['user_application_visitors.deleted_at' => null, 'user_application_visitors.seen_at' => null, 'user_application_visitors.user_id' => $input['id']])
                ->count();
                $likes[$u]->profile = $user['profile'];
                $likes[$u]->application_user_images = $user['application_user_images'];
            }
            /// //////////////////////

            DB::table('user_application_likes')
            ->where('user_id', $input['user_id'])
            ->where(['seen_at' => null])
            ->update(['seen_at' => Carbon::now()->toDateTimeString()]);

            DB::table('application_users')
            ->where('id', $input['user_id'])
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);

            return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $likes), \Illuminate\Http\Response::HTTP_OK);
        });

    Route::post('blocks', function (Request $request) {
        $input = $request->all();
        $likes = DB::table('user_application_blocks')
        ->where(['user_application_blocks.deleted_at' => null, 'user_application_blocks.from_user_id' => $input['user_id']])
        ->join('application_users', 'user_application_blocks.user_id', '=', 'application_users.id')
        ->select('user_application_blocks.user_id', 'user_application_blocks.created_at', 'application_users.name', 'application_users.username', 'application_users.image')->get();
            /**********************************
             * change image url
             **********************************/
            if (sizeof($likes) != 0) {
                $likes[0]->image = "http://awa.m-apps.co/" . $likes[0]->image;
            }

            /////////////////////
            for ($u = 0; $u < sizeof($likes); $u++) {
                $user['profile'] = DB::table('application_users')
                ->where('application_users.status', '<>', 'banded')
                ->where(['application_users.deleted_at' => null, 'application_users.id' => $likes[$u]->user_id])
                ->join('countries', 'application_users.country_code', '=', 'countries.code')
                ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
                ->select('application_users.*', 'countries.ar_name as country_name', 'registration_aims.value as registration_aim')
                ->get();
                $user['application_user_images'] = DB::table('application_user_images')
                ->where(['deleted_at' => null, 'application_user_id' => $likes[$u]->user_id])
                ->get();


                /**********************************
                 * change image url
                 **********************************/
                $user['profile'][0]->image = "http://awa.m-apps.co/" . $user['profile'][0]->image;
                foreach ($user['application_user_images'] as $userImage) {
                    $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
                }

                if ($user['profile'][0]->nationality_code != null) {
                    $user['profile'][0]->nationality_name = DB::table('nationalities')
                    ->where(['deleted_at' => null, 'code' => $user['profile'][0]->nationality_code])
                    ->select('nationalities.ar_name as nationality_name')
                    ->first()->nationality_name;
                } else {
                    $user['profile'][0]->nationality_name = null;
                }

                if ($user['profile'][0]->age_id != null) {
                    $user['profile'][0]->age = DB::table('ages')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->age_id])
                    ->select('ages.value as age')
                    ->first()->age;
                } else {
                    $user['profile'][0]->age = null;
                }

                if ($user['profile'][0]->educational_qualification_id != null) {
                    $user['profile'][0]->educational_qualification = DB::table('educational_qualifications')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->educational_qualification_id])
                    ->select('educational_qualifications.value as educational_qualification')
                    ->first()->educational_qualification;
                } else {
                    $user['profile'][0]->educational_qualification = null;
                }

                if ($user['profile'][0]->eye_color_id != null) {
                    $user['profile'][0]->eye_color = DB::table('eye_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->eye_color_id])
                    ->select('eye_colors.value as eye_color')
                    ->first()->eye_color;
                } else {
                    $user['profile'][0]->eye_color = null;
                }

                if ($user['profile'][0]->skin_color_id != null) {
                    $user['profile'][0]->skin_color = DB::table('skin_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->skin_color_id])
                    ->select('skin_colors.value as skin_color')
                    ->first()->skin_color;
                } else {
                    $user['profile'][0]->skin_color = null;
                }

                if ($user['profile'][0]->hair_color_id != null) {
                    $user['profile'][0]->hair_color = DB::table('hair_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->hair_color_id])
                    ->select('hair_colors.value as hair_color')
                    ->first()->hair_color;
                } else {
                    $user['profile'][0]->hair_color = null;
                }


                if ($user['profile'][0]->social_status_id != null) {
                    $user['profile'][0]->social_status = DB::table('social_statuses')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->social_status_id])
                    ->select('social_statuses.value as social_status')
                    ->first()->social_status;
                } else {
                    $user['profile'][0]->social_status = null;
                }

                if ($user['profile'][0]->occupation_id != null) {
                    $user['profile'][0]->occupation = DB::table('occupations')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->occupation_id])
                    ->select('occupations.value as occupation')
                    ->first()->occupation;
                } else {
                    $user['profile'][0]->occupation = null;
                }

                if ($user['profile'][0]->length_category_id != null) {
                    $user['profile'][0]->length_category = DB::table('length_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->length_category_id])
                    ->select('length_categories.value as length_category')
                    ->first()->length_category;
                } else {
                    $user['profile'][0]->length_category = null;
                }

                if ($user['profile'][0]->weight_category_id != null) {
                    $user['profile'][0]->weight_category = DB::table('weight_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->weight_category_id])
                    ->select('weight_categories.value as weight_category')
                    ->first()->weight_category;
                } else {
                    $user['profile'][0]->weight_category = null;
                }

                if ($user['profile'][0]->gender == 'male') {
                    $user['profile'][0]->gender_title = "ذكر";
                } else {
                    $user['profile'][0]->gender_title = "أنثى";
                }

                $Conversations = DB::table('convsersations')
                ->where(['convsersations.to_user_id' => $input['id']])
                ->orWhere(['convsersations.from_user_id' => $input['id']])
                ->get();
                $MessagesCount = 0;
                for ($i = 0; $i < sizeof($Conversations); $i++) {
                    if ($Conversations[$i]->deleted_at == null) {

                        $ConversationDetails = DB::table('conversation_info')
                        ->where('conversation_info.from_id', '<>', $input['id'])
                        ->where(['conversation_info.deleted_at' => null])
                        ->where(['conversation_info.seen_to' => null])
                        ->where(['conversation_info.conversation_id' => $Conversations[$i]->id])
                        ->get();
                        if (sizeof($ConversationDetails) > 0) {
                            $MessagesCount = $MessagesCount + sizeof($ConversationDetails);
                        }
                    }

                }
                $user['profile'][0]->new_messsages_count = $MessagesCount;

                $user['profile'][0]->new_likes_count = DB::table('user_application_likes')
                ->where(['user_application_likes.deleted_at' => null, 'user_application_likes.seen_at' => null, 'user_application_likes.user_id' => $input['id']])
                ->count();
                $user['profile'][0]->new_visitors_count = DB::table('user_application_visitors')
                ->where(['user_application_visitors.deleted_at' => null, 'user_application_visitors.seen_at' => null, 'user_application_visitors.user_id' => $input['id']])
                ->count();
                $likes[$u]->profile = $user['profile'];
                $likes[$u]->application_user_images = $user['application_user_images'];
            }
            /// //////////////////////

            DB::table('application_users')
            ->where('id', $input['user_id'])
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);
            return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $likes), \Illuminate\Http\Response::HTTP_OK);
        });

    Route::post('visits', function (Request $request) {
        $input = $request->all();
        $visits = DB::table('user_application_visitors')
        ->where(['user_application_visitors.deleted_at' => null, 'user_application_visitors.user_id' => $input['user_id']])
        ->join('application_users', 'user_application_visitors.from_user_id', '=', 'application_users.id')
        ->select('user_application_visitors.from_user_id as user_id', 'user_application_visitors.created_at', 'application_users.name', 'application_users.username', 'application_users.image')->get();
            /**********************************
             * change image url
             **********************************/
            // if (sizeof($visits) != 0) {
            //     $visits[0]->image = "http://awa.m-apps.co/" . $visits[0]->image;
            // }

            for ($u = 0; $u < sizeof($visits); $u++) {
                $visits[$u]->image = "http://awa.m-apps.co/" . $visits[$u]->image;
            }


            /////////////////////
            for ($u = 0; $u < sizeof($visits); $u++) {
                $user['profile'] = DB::table('application_users')
                ->where('application_users.status', '<>', 'banded')
                ->where(['application_users.deleted_at' => null, 'application_users.id' => $visits[$u]->user_id])
                ->join('countries', 'application_users.country_code', '=', 'countries.code')
                ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
                ->select('application_users.*', 'countries.ar_name as country_name', 'registration_aims.value as registration_aim')
                ->get();
                $user['application_user_images'] = DB::table('application_user_images')
                ->where(['deleted_at' => null, 'application_user_id' => $visits[$u]->user_id])
                ->get();


                /**********************************
                 * change image url
                 **********************************/
                $user['profile'][0]->image = "http://awa.m-apps.co/" . $user['profile'][0]->image;
                foreach ($user['application_user_images'] as $userImage) {
                    $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
                }

                if ($user['profile'][0]->nationality_code != null) {
                    $user['profile'][0]->nationality_name = DB::table('nationalities')
                    ->where(['deleted_at' => null, 'code' => $user['profile'][0]->nationality_code])
                    ->select('nationalities.ar_name as nationality_name')
                    ->first()->nationality_name;
                } else {
                    $user['profile'][0]->nationality_name = null;
                }

                if ($user['profile'][0]->age_id != null) {
                    $user['profile'][0]->age = DB::table('ages')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->age_id])
                    ->select('ages.value as age')
                    ->first()->age;
                } else {
                    $user['profile'][0]->age = null;
                }

                if ($user['profile'][0]->educational_qualification_id != null) {
                    $user['profile'][0]->educational_qualification = DB::table('educational_qualifications')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->educational_qualification_id])
                    ->select('educational_qualifications.value as educational_qualification')
                    ->first()->educational_qualification;
                } else {
                    $user['profile'][0]->educational_qualification = null;
                }

                if ($user['profile'][0]->eye_color_id != null) {
                    $user['profile'][0]->eye_color = DB::table('eye_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->eye_color_id])
                    ->select('eye_colors.value as eye_color')
                    ->first()->eye_color;
                } else {
                    $user['profile'][0]->eye_color = null;
                }

                if ($user['profile'][0]->skin_color_id != null) {
                    $user['profile'][0]->skin_color = DB::table('skin_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->skin_color_id])
                    ->select('skin_colors.value as skin_color')
                    ->first()->skin_color;
                } else {
                    $user['profile'][0]->skin_color = null;
                }

                if ($user['profile'][0]->hair_color_id != null) {
                    $user['profile'][0]->hair_color = DB::table('hair_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->hair_color_id])
                    ->select('hair_colors.value as hair_color')
                    ->first()->hair_color;
                } else {
                    $user['profile'][0]->hair_color = null;
                }


                if ($user['profile'][0]->social_status_id != null) {
                    $user['profile'][0]->social_status = DB::table('social_statuses')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->social_status_id])
                    ->select('social_statuses.value as social_status')
                    ->first()->social_status;
                } else {
                    $user['profile'][0]->social_status = null;
                }

                if ($user['profile'][0]->occupation_id != null) {
                    $user['profile'][0]->occupation = DB::table('occupations')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->occupation_id])
                    ->select('occupations.value as occupation')
                    ->first()->occupation;
                } else {
                    $user['profile'][0]->occupation = null;
                }

                if ($user['profile'][0]->length_category_id != null) {
                    $user['profile'][0]->length_category = DB::table('length_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->length_category_id])
                    ->select('length_categories.value as length_category')
                    ->first()->length_category;
                } else {
                    $user['profile'][0]->length_category = null;
                }

                if ($user['profile'][0]->weight_category_id != null) {
                    $user['profile'][0]->weight_category = DB::table('weight_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->weight_category_id])
                    ->select('weight_categories.value as weight_category')
                    ->first()->weight_category;
                } else {
                    $user['profile'][0]->weight_category = null;
                }

                if ($user['profile'][0]->gender == 'male') {
                    $user['profile'][0]->gender_title = "ذكر";
                } else {
                    $user['profile'][0]->gender_title = "أنثى";
                }

                $Conversations = DB::table('convsersations')
                ->where(['convsersations.to_user_id' => $input['id']])
                ->orWhere(['convsersations.from_user_id' => $input['id']])
                ->get();
                $MessagesCount = 0;
                for ($i = 0; $i < sizeof($Conversations); $i++) {
                    if ($Conversations[$i]->deleted_at == null) {

                        $ConversationDetails = DB::table('conversation_info')
                        ->where('conversation_info.from_id', '<>', $input['id'])
                        ->where(['conversation_info.deleted_at' => null])
                        ->where(['conversation_info.seen_to' => null])
                        ->where(['conversation_info.conversation_id' => $Conversations[$i]->id])
                        ->get();
                        if (sizeof($ConversationDetails) > 0) {
                            $MessagesCount = $MessagesCount + sizeof($ConversationDetails);
                        }
                    }

                }
                $user['profile'][0]->new_messsages_count = $MessagesCount;

                $user['profile'][0]->new_likes_count = DB::table('user_application_likes')
                ->where(['user_application_likes.deleted_at' => null, 'user_application_likes.seen_at' => null, 'user_application_likes.user_id' => $input['id']])
                ->count();
                $user['profile'][0]->new_visitors_count = DB::table('user_application_visitors')
                ->where(['user_application_visitors.deleted_at' => null, 'user_application_visitors.seen_at' => null, 'user_application_visitors.user_id' => $input['id']])
                ->count();
                $visits[$u]->profile = $user['profile'];
                $visits[$u]->application_user_images = $user['application_user_images'];
            }
            /// //////////////////////

            DB::table('user_application_visitors')
            ->where('user_id', $input['user_id'])
            ->where(['seen_at' => null])
            ->update(['seen_at' => Carbon::now()->toDateTimeString()]);

            DB::table('application_users')
            ->where('id', $input['user_id'])
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);

            return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $visits), \Illuminate\Http\Response::HTTP_OK);
        });

    Route::post('notifications', function (Request $request) {
        $input = $request->all();
        $visits = DB::table('application_users_notifications')
        ->where(['application_users_notifications.user_id' => $input['user_id']])
        ->where('application_users_notifications.type', '<>', 'message')
        ->join('application_users', 'application_users_notifications.user_id', '=', 'application_users.id')
        ->select('application_users_notifications.*', 'application_users.name', 'application_users.username', 'application_users.image')->get();
        $visitsCount = DB::table('application_users_notifications')
        ->where(['application_users_notifications.user_id' => $input['user_id']])
        ->where('application_users_notifications.type', '<>', 'message')
        ->where(['seen_at' => null])
        ->join('application_users', 'application_users_notifications.user_id', '=', 'application_users.id')
        ->select('application_users_notifications.*', 'application_users.name', 'application_users.username', 'application_users.image')->count();


            /**********************************
             * change image url
             **********************************/
            for($i=0;$i<sizeof($visits) ;$i++){
                $visits[$i]->image = "http://awa.m-apps.co/" . $visits[$i]->image;
            }

            DB::table('application_users')
            ->where('id', $input['user_id'])
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);
            
            DB::table('application_users_notifications')
            ->where('user_id', $input['user_id'])
            ->where(['seen_at' => null])
            ->update(['seen_at' => Carbon::now()->toDateTimeString()]);

            return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $visits, "unSeenCount" => $visitsCount), \Illuminate\Http\Response::HTTP_OK);
        });

    Route::post('like', function (Request $request) {
        $input = $request->all();

        $user = DB::table('application_users')->where(
            ['id' => $input['from_user_id']]
        )->first();
        if($user->isPay != 1){
            $countLikes = DB::table('user_application_likes')->where(
                ['from_user_id' => $input['from_user_id']]
            )->count();
            if($countLikes >= 3){
                return response(array("status" => false, "message" => "عذراً، لقد تجاوزت الحد المسموح لك من الإعجابات قم بترقية العضوية", "data" => $likes), \Illuminate\Http\Response::HTTP_OK);

            }

        }

        $count = DB::table('user_application_likes')->where(
            ['from_user_id' => $input['from_user_id'], 'user_id' => $input['to_user_id']]
        )->count();

        if ($count == 0) {
            $like = DB::table('user_application_likes')->insert(
                ['from_user_id' => $input['from_user_id'], 'user_id' => $input['to_user_id']]
            );
                ////////////////////////
                ///  Send Notification /
                /// /////////////////////

            $SendUser = DB::table('application_users')->select('id', 'firebase_token', 'device_type', 'username')->where('id', '=', $input['from_user_id'])->first();
            $users = DB::table('application_users')->select('id', 'firebase_token', 'device_type', 'username')->where('id', '=', $input['to_user_id'])->get();
            foreach ($users as $user) {
                $message = "لديك إعجاب جديد من " . $SendUser->username;
                $appName = "حوراء";
                DB::table('application_users_notifications')->insert(
                    ['user_id' => $user->id, 'content' => $message, 'type' => 'like', 'details' => $input['from_user_id']]
                );

                if ($user->firebase_token != NULL && $user->firebase_token != "NULL" && $user->firebase_token != "") {
                    if ($user->device_type != NULL && $user->device_type != "NULL" && $user->device_type != "") {
                        if ($user->device_type == "android") {
                            $url = 'https://fcm.googleapis.com/fcm/send';
                            $data = array(
                                'notification' => array(
                                    'alert' => array(
                                        'title' => $appName,
                                        'body' => $message,
                                        'sound' => 'default'
                                    )
                                ),
                                'message' => $message
                            );
                            $fields = array(
                                'data' => $data,
                                'to' => $user->firebase_token
                            );
                            $headers = array(
                                'Authorization:key=AIzaSyB7YjkicaSIjXs8rslJpxN3rhYpOjysB6A',
                                'Content-Type: application/json'
                            );

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                            $result = curl_exec($ch);
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                            curl_close($ch);
                        }
                    }
                }
            }


                ////////////////////////////////
                ///  End Send Notification
                /// ///////////////////////////
        }


        $likes = DB::table('user_application_likes')
        ->where(['user_application_likes.deleted_at' => null, 'user_application_likes.user_id' => $input['to_user_id']])
        ->join('application_users', 'user_application_likes.from_user_id', '=', 'application_users.id')
        ->select('user_application_likes.from_user_id as user_id', 'user_application_likes.created_at', 'application_users.name', 'application_users.username', 'application_users.image')->get();
            /**********************************
             * change image url
             **********************************/
            if (sizeof($likes) != 0) {
                $likes[0]->image = "http://awa.m-apps.co/" . $likes[0]->image;
            }

            DB::table('application_users')
            ->where('id', $input['from_user_id'])
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);

            return response(array("status" => true, "message" => "تمت الإضافة بنجاح", "data" => $likes), \Illuminate\Http\Response::HTTP_OK);
        });

    Route::post('disLike', function (Request $request) {
        $input = $request->all();

        $count = DB::table('user_application_likes')->where(
            ['from_user_id' => $input['from_user_id'], 'user_id' => $input['to_user_id']]
        )->delete();



        $likes = DB::table('user_application_likes')
        ->where(['user_application_likes.deleted_at' => null, 'user_application_likes.user_id' => $input['to_user_id']])
        ->join('application_users', 'user_application_likes.from_user_id', '=', 'application_users.id')
        ->select('user_application_likes.from_user_id as user_id', 'user_application_likes.created_at', 'application_users.name', 'application_users.username', 'application_users.image')->get();
            /**********************************
             * change image url
             **********************************/
            if (sizeof($likes) != 0) {
                $likes[0]->image = "http://awa.m-apps.co/" . $likes[0]->image;
            }

            DB::table('application_users')
            ->where('id', $input['from_user_id'])
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);

            return response(array("status" => true, "message" => "تمت الإزالة بنجاح", "data" => $likes), \Illuminate\Http\Response::HTTP_OK);
        });

    Route::post('visit', function (Request $request) {
        $input = $request->all();

        $count = DB::table('user_application_visitors')->where(
            ['from_user_id' => $input['from_user_id'], 'user_id' => $input['to_user_id']]
        )->count();

        if ($count == 0) {
            $visit = DB::table('user_application_visitors')->insert(
                ['from_user_id' => $input['from_user_id'], 'user_id' => $input['to_user_id']]
            );
                ////////////////////////
                ///  Send Notification /
                /// /////////////////////

            $SendUser = DB::table('application_users')->select('id', 'firebase_token', 'device_type', 'username')->where('id', '=', $input['from_user_id'])->first();
            $users = DB::table('application_users')->select('id', 'firebase_token', 'device_type', 'username')->where('id', '=', $input['to_user_id'])->get();
            foreach ($users as $user) {
                $message = "لديك زيارة جديدة من " . $SendUser->username;
                $appName = "حوراء";
                DB::table('application_users_notifications')->insert(
                    ['user_id' => $user->id, 'content' => $message, 'type' => 'visit', 'details' => $input['from_user_id']]
                );

                if ($user->firebase_token != NULL && $user->firebase_token != "NULL" && $user->firebase_token != "") {
                    if ($user->device_type != NULL && $user->device_type != "NULL" && $user->device_type != "") {
                        if ($user->device_type == "android") {
                            $url = 'https://fcm.googleapis.com/fcm/send';
                            $data = array(
                                'notification' => array(
                                    'alert' => array(
                                        'title' => $appName,
                                        'body' => $message,
                                        'sound' => 'default'
                                    )
                                ),
                                'message' => $message
                            );
                            $fields = array(
                                'data' => $data,
                                'to' => $user->firebase_token
                            );
                            $headers = array(
                                'Authorization:key=AIzaSyB7YjkicaSIjXs8rslJpxN3rhYpOjysB6A',
                                'Content-Type: application/json'
                            );

                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                            $result = curl_exec($ch);
                            if ($result === FALSE) {
                                die('Curl failed: ' . curl_error($ch));
                            }
                            curl_close($ch);
                        }
                    }
                }
            }


                ////////////////////////////////
                ///  End Send Notification
                /// ///////////////////////////
        }


        $visits = DB::table('user_application_visitors')
        ->where(['user_application_visitors.deleted_at' => null, 'user_application_visitors.user_id' => $input['to_user_id']])
        ->join('application_users', 'user_application_visitors.from_user_id', '=', 'application_users.id')
        ->select('user_application_visitors.from_user_id as user_id', 'user_application_visitors.created_at', 'application_users.name', 'application_users.username', 'application_users.image')->get();

            /**********************************
             * change image url
             **********************************/
            if (sizeof($visits) != 0) {
                $visits[0]->image = "http://awa.m-apps.co/" . $visits[0]->image;
            }

            DB::table('application_users')
            ->where('id', $input['from_user_id'])
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);

            return response(array("status" => true, "message" => "تمت الإضافة بنجاح", "data" => $visits), \Illuminate\Http\Response::HTTP_OK);
        });

    Route::post('block', function (Request $request) {
        $input = $request->all();

        $count = DB::table('user_application_blocks')->where(
            ['from_user_id' => $input['from_user_id'], 'user_id' => $input['to_user_id']]
        )->count();

        if ($count == 0) {
            $visit = DB::table('user_application_blocks')->insert(
                ['from_user_id' => $input['from_user_id'], 'user_id' => $input['to_user_id']]
            );
        }


        $visits = DB::table('user_application_blocks')
        ->where(['user_application_blocks.deleted_at' => null, 'user_application_blocks.user_id' => $input['to_user_id']])
        ->join('application_users', 'user_application_blocks.user_id', '=', 'application_users.id')
        ->select('user_application_blocks.user_id as user_id', 'user_application_blocks.created_at', 'application_users.name', 'application_users.username', 'application_users.image')->get();
            /**********************************
             * change image url
             **********************************/
            if (sizeof($visits) != 0) {
                $visits[0]->image = "http://awa.m-apps.co/" . $visits[0]->image;
            }

            DB::table('application_users')
            ->where('id', $input['from_user_id'])
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);

            return response(array("status" => true, "message" => "تمت الإضافة بنجاح", "data" => $visits), \Illuminate\Http\Response::HTTP_OK);
        });

    Route::post('removeBlock', function (Request $request) {
        $input = $request->all();

        $count = DB::table('user_application_blocks')->where(
            ['from_user_id' => $input['from_user_id'], 'user_id' => $input['to_user_id']]
        )->delete();



        $visits = DB::table('user_application_blocks')
        ->where(['user_application_blocks.deleted_at' => null, 'user_application_blocks.user_id' => $input['to_user_id']])
        ->join('application_users', 'user_application_blocks.user_id', '=', 'application_users.id')
        ->select('user_application_blocks.user_id as user_id', 'user_application_blocks.created_at', 'application_users.name', 'application_users.username', 'application_users.image')->get();
            /**********************************
             * change image url
             **********************************/
            if (sizeof($visits) != 0) {
                $visits[0]->image = "http://awa.m-apps.co/" . $visits[0]->image;
            }

            DB::table('application_users')
            ->where('id', $input['from_user_id'])
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);

            return response(array("status" => true, "message" => "تمت الازالة بنجاح", "data" => $visits), \Illuminate\Http\Response::HTTP_OK);
        });

    Route::post('similarUsers', function (Request $request) {
        $input = $request->all();
        $user['profile'] = DB::table('application_users')
        ->where('application_users.status', '<>', 'banded')
        ->where(['application_users.deleted_at' => null, 'application_users.id' => $input['user_id']])
        ->join('countries', 'application_users.country_code', '=', 'countries.code')
        ->join('nationalities', 'application_users.nationality_code', '=', 'nationalities.code')
        ->join('ages', 'application_users.age_id', '=', 'ages.id')
        ->join('educational_qualifications', 'application_users.educational_qualification_id', '=', 'educational_qualifications.id')
        ->join('eye_colors', 'application_users.eye_color_id', '=', 'eye_colors.id')
        ->join('skin_colors', 'application_users.skin_color_id', '=', 'skin_colors.id')
        ->join('hair_colors', 'application_users.hair_color_id', '=', 'hair_colors.id')
        ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
        ->join('social_statuses', 'application_users.social_status_id', '=', 'social_statuses.id')
        ->join('occupations', 'application_users.occupation_id', '=', 'occupations.id')
        ->join('length_categories', 'application_users.length_category_id', '=', 'length_categories.id')
        ->join('weight_categories', 'application_users.weight_category_id', '=', 'weight_categories.id')
        ->select('application_users.*', 'countries.ar_name as country_name', 'nationalities.ar_name as nationality_name', 'ages.value as age',
            'educational_qualifications.value as educational_qualification', 'eye_colors.value as eye_color',
            'registration_aims.value as registration_aim', 'social_statuses.value as social_status',
            'occupations.value as occupation', 'skin_colors.value as skin_color', 'hair_colors.value as hair_color',
            'length_categories.value as length_category', 'weight_categories.value as weight_category')
        ->get();
        $user['application_user_images'] = DB::table('application_user_images')
        ->where(['deleted_at' => null, 'application_user_id' => $input['user_id']])
        ->get();

            /**********************************
             * change image url
             **********************************/
            $user['profile'][0]->image = "http://awa.m-apps.co/" . $user['profile'][0]->image;
            foreach ($user['application_user_images'] as $userImage) {
                $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
            }

            $users = DB::table('application_users')
            ->where('application_users.status', '<>', 'banded')
            ->where('application_users.gender', '<>', $user['profile'][0]->gender)
            ->where('application_users.id', '<>', $input['user_id'])
            ->where('application_users.deleted_at', '=', null)
            ->where('application_users.registration_aim_id', '=', $user['profile'][0]->registration_aim_id)
            ->join('countries', 'application_users.country_code', '=', 'countries.code')
            ->join('nationalities', 'application_users.nationality_code', '=', 'nationalities.code')
            ->join('ages', 'application_users.age_id', '=', 'ages.id')
            ->join('educational_qualifications', 'application_users.educational_qualification_id', '=', 'educational_qualifications.id')
            ->join('eye_colors', 'application_users.eye_color_id', '=', 'eye_colors.id')
            ->join('skin_colors', 'application_users.skin_color_id', '=', 'skin_colors.id')
            ->join('hair_colors', 'application_users.hair_color_id', '=', 'hair_colors.id')
            ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
            ->join('social_statuses', 'application_users.social_status_id', '=', 'social_statuses.id')
            ->join('occupations', 'application_users.occupation_id', '=', 'occupations.id')
            ->join('length_categories', 'application_users.length_category_id', '=', 'length_categories.id')
            ->join('weight_categories', 'application_users.weight_category_id', '=', 'weight_categories.id')
            ->select('application_users.*', 'countries.ar_name as country_name', 'nationalities.ar_name as nationality_name', 'ages.value as age',
                'educational_qualifications.value as educational_qualification', 'eye_colors.value as eye_color',
                'registration_aims.value as registration_aim', 'social_statuses.value as social_status',
                'occupations.value as occupation', 'skin_colors.value as skin_color', 'hair_colors.value as hair_color',
                'length_categories.value as length_category', 'weight_categories.value as weight_category')
            ->orderBy('application_users.created_at', 'asc')
            ->limit(10)
            ->get();

            /**********************************
             * change image url
             **********************************/

            if (sizeof($users) != 0) {
                $newUsers = array();
                for ($i = 0; $i < sizeof($users); $i++) {
                    $user = $users[$i];

                    $user->image = "http://awa.m-apps.co/" . $user->image;

                    $images = DB::table('application_user_images')
                    ->where(['deleted_at' => null, 'application_user_id' => $user->id])
                    ->get();
                    /**********************************
                     * change image url
                     **********************************/
                    foreach ($images as $userImage) {
                        $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
                    }

                    $count = DB::table('user_application_likes')->where(
                        ['from_user_id' => $input['user_id'], 'user_id' => $user->id]
                    )->count();

                    if ($count == 0) {
                        $user->is_like = false;
                    } else {
                        $user->is_like = true;
                    }

                    if ($user->gender == 'male') {
                        $user->gender_title = "ذكر";
                    } else {
                        $user->gender_title = "أنثى";
                    }


                    $newUsers[]['profile'][0] = $user;
                    $newUsers[$i]['application_user_images'] = $images;


                }

            }

            DB::table('application_users')
            ->where('id', $input['user_id'])
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);

            if($newUsers == null ){
                $newUsers = array();
            }
            return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $newUsers), \Illuminate\Http\Response::HTTP_OK);

        });

    Route::post('newUsers', function (Request $request) {
        $input = $request->all();
        $user['profile'] = DB::table('application_users')
        ->where('application_users.status', '<>', 'banded')
        ->where(['application_users.deleted_at' => null, 'application_users.id' => $input['user_id']])
        ->join('countries', 'application_users.country_code', '=', 'countries.code')
        ->join('nationalities', 'application_users.nationality_code', '=', 'nationalities.code')
        ->join('ages', 'application_users.age_id', '=', 'ages.id')
        ->join('educational_qualifications', 'application_users.educational_qualification_id', '=', 'educational_qualifications.id')
        ->join('eye_colors', 'application_users.eye_color_id', '=', 'eye_colors.id')
        ->join('skin_colors', 'application_users.skin_color_id', '=', 'skin_colors.id')
        ->join('hair_colors', 'application_users.hair_color_id', '=', 'hair_colors.id')
        ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
        ->join('social_statuses', 'application_users.social_status_id', '=', 'social_statuses.id')
        ->join('occupations', 'application_users.occupation_id', '=', 'occupations.id')
        ->join('length_categories', 'application_users.length_category_id', '=', 'length_categories.id')
        ->join('weight_categories', 'application_users.weight_category_id', '=', 'weight_categories.id')
        ->select('application_users.*', 'countries.ar_name as country_name', 'nationalities.ar_name as nationality_name', 'ages.value as age',
            'educational_qualifications.value as educational_qualification', 'eye_colors.value as eye_color',
            'registration_aims.value as registration_aim', 'social_statuses.value as social_status',
            'occupations.value as occupation', 'skin_colors.value as skin_color', 'hair_colors.value as hair_color',
            'length_categories.value as length_category', 'weight_categories.value as weight_category')
        ->get();
        $user['application_user_images'] = DB::table('application_user_images')
        ->where(['deleted_at' => null, 'application_user_id' => $input['user_id']])
        ->get();

            /**********************************
             * change image url
             **********************************/
            $user['profile'][0]->image = "http://awa.m-apps.co/" . $user['profile'][0]->image;
            foreach ($user['application_user_images'] as $userImage) {
                $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
            }

            $users = DB::table('application_users')
            ->where('application_users.status', '<>', 'banded')
            ->where('application_users.gender', '<>', $user['profile'][0]->gender)
            ->where('application_users.id', '<>', $input['user_id'])
            ->where('application_users.deleted_at', '=', null)
            ->join('countries', 'application_users.country_code', '=', 'countries.code')
            ->join('nationalities', 'application_users.nationality_code', '=', 'nationalities.code')
            ->join('ages', 'application_users.age_id', '=', 'ages.id')
            ->join('educational_qualifications', 'application_users.educational_qualification_id', '=', 'educational_qualifications.id')
            ->join('eye_colors', 'application_users.eye_color_id', '=', 'eye_colors.id')
            ->join('skin_colors', 'application_users.skin_color_id', '=', 'skin_colors.id')
            ->join('hair_colors', 'application_users.hair_color_id', '=', 'hair_colors.id')
            ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
            ->join('social_statuses', 'application_users.social_status_id', '=', 'social_statuses.id')
            ->join('occupations', 'application_users.occupation_id', '=', 'occupations.id')
            ->join('length_categories', 'application_users.length_category_id', '=', 'length_categories.id')
            ->join('weight_categories', 'application_users.weight_category_id', '=', 'weight_categories.id')
            ->select('application_users.*', 'countries.ar_name as country_name', 'nationalities.ar_name as nationality_name', 'ages.value as age',
                'educational_qualifications.value as educational_qualification', 'eye_colors.value as eye_color',
                'registration_aims.value as registration_aim', 'social_statuses.value as social_status',
                'occupations.value as occupation', 'skin_colors.value as skin_color', 'hair_colors.value as hair_color',
                'length_categories.value as length_category', 'weight_categories.value as weight_category')
            ->orderBy('application_users.created_at', 'asc')
            ->limit(10)
            ->get();
            /**********************************
             * change image url
             **********************************/
            if (sizeof($users) != 0) {
                $newUsers = array();
                for ($i = 0; $i < sizeof($users); $i++) {
                    $user = $users[$i];

                    $user->image = "http://awa.m-apps.co/" . $user->image;
                    $images = DB::table('application_user_images')
                    ->where(['deleted_at' => null, 'application_user_id' => $user->id])
                    ->get();
                    /**********************************
                     * change image url
                     **********************************/
                    foreach ($images as $userImage) {
                        $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
                    }

                    $count = DB::table('user_application_likes')->where(
                        ['from_user_id' => $input['user_id'], 'user_id' => $user->id]
                    )->count();

                    if ($count == 0) {
                        $user->is_like = false;
                    } else {
                        $user->is_like = true;
                    }

                    if ($user->gender == 'male') {
                        $user->gender_title = "ذكر";
                    } else {
                        $user->gender_title = "أنثى";
                    }


                    $newUsers[]['profile'][0] = $user;
                    $newUsers[$i]['application_user_images'] = $images;


                }

            }

            DB::table('application_users')
            ->where('id', $input['user_id'])
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);


            return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $newUsers), \Illuminate\Http\Response::HTTP_OK);

        });

    Route::post('updateToken', function (Request $request) {
        $input = $request->all();
        DB::table('application_users')
        ->where('id', $input['user_id'])
        ->update(['last_seen' => Carbon::now()->toDateTimeString(), 'device_type' => $input['device_type'], 'firebase_token' => $input['firebase_token']]);
        return response(array("status" => true, "message" => "تم التعديل بنجاح", "data" => null), \Illuminate\Http\Response::HTTP_OK);
    });

});


Route::prefix('auth')->group(function () {
    Route::post('login', function (Request $request) {
        $isFound = false;
        $success = false;
        $message = "مرحبا بك، تفضل بالدخول";
        $input = $request->all();
        $user = DB::table('application_users')
        ->where(['application_users.deleted_at' => null])
        ->where(['application_users.username' => $input['username']])
        ->get();
        if (count($user) == 1) {
            $isFound = true;
        } else {
            $user = DB::table('application_users')
            ->where(['application_users.deleted_at' => null])
            ->where(['application_users.email' => $input['username']])
            ->get();
            if (count($user) == 1) {
                $isFound = true;
            }
        }

        if ($isFound) {
            if (Hash::check($input['password'], $user[0]->password)) {
                $success = true;
                $id = $user[0]->id;
                DB::table('application_users')
                ->where('id', $id)
                ->update(['last_seen' => Carbon::now()->toDateTimeString()]);

                $user = null;
                $user['profile'] = DB::table('application_users')
                ->where('application_users.status', '<>', 'banded')
                ->where(['application_users.deleted_at' => null, 'application_users.id' => $id])
                ->join('countries', 'application_users.country_code', '=', 'countries.code')
                ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
                ->select('application_users.*', 'countries.ar_name as country_name', 'registration_aims.value as registration_aim')
                ->get();
                $user['application_user_images'] = DB::table('application_user_images')
                ->where(['deleted_at' => null, 'application_user_id' => $id])
                ->get();

                /**********************************
                 * change image url
                 **********************************/
                $user['profile'][0]->image = "http://awa.m-apps.co/" . $user['profile'][0]->image;
                foreach ($user['application_user_images'] as $userImage) {
                    $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
                }

                if ($user['profile'][0]->isPay != 0) {
                    $user['profile'][0]->subscription_id = DB::table('banks_transfers')
                    ->where(['deleted_at' => null, 'user_id' => $id])
                    ->first()->subscription_id;
                } else{
                    $user['profile'][0]->subscription_id = 3;
                }

                if ($user['profile'][0]->nationality_code != null) {
                    $user['profile'][0]->nationality_name = DB::table('nationalities')
                    ->where(['deleted_at' => null, 'code' => $user['profile'][0]->nationality_code])
                    ->select('nationalities.ar_name as nationality_name')
                    ->first()->nationality_name;
                } else {
                    $user['profile'][0]->nationality_name = null;
                }

                if ($user['profile'][0]->age_id != null) {
                    $user['profile'][0]->age = DB::table('ages')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->age_id])
                    ->select('ages.value as age')
                    ->first()->age;
                } else {
                    $user['profile'][0]->age = null;
                }

                if ($user['profile'][0]->educational_qualification_id != null) {
                    $user['profile'][0]->educational_qualification = DB::table('educational_qualifications')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->educational_qualification_id])
                    ->select('educational_qualifications.value as educational_qualification')
                    ->first()->educational_qualification;
                } else {
                    $user['profile'][0]->educational_qualification = null;
                }

                if ($user['profile'][0]->eye_color_id != null) {
                    $user['profile'][0]->eye_color = DB::table('eye_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->eye_color_id])
                    ->select('eye_colors.value as eye_color')
                    ->first()->eye_color;
                } else {
                    $user['profile'][0]->eye_color = null;
                }

                if ($user['profile'][0]->skin_color_id != null) {
                    $user['profile'][0]->skin_color = DB::table('skin_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->skin_color_id])
                    ->select('skin_colors.value as skin_color')
                    ->first()->skin_color;
                } else {
                    $user['profile'][0]->skin_color = null;
                }

                if ($user['profile'][0]->hair_color_id != null) {
                    $user['profile'][0]->hair_color = DB::table('hair_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->hair_color_id])
                    ->select('hair_colors.value as hair_color')
                    ->first()->hair_color;
                } else {
                    $user['profile'][0]->hair_color = null;
                }


                if ($user['profile'][0]->social_status_id != null) {
                    $user['profile'][0]->social_status = DB::table('social_statuses')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->social_status_id])
                    ->select('social_statuses.value as social_status')
                    ->first()->social_status;
                } else {
                    $user['profile'][0]->social_status = null;
                }

                if ($user['profile'][0]->occupation_id != null) {
                    $user['profile'][0]->occupation = DB::table('occupations')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->occupation_id])
                    ->select('occupations.value as occupation')
                    ->first()->occupation;
                } else {
                    $user['profile'][0]->occupation = null;
                }

                if ($user['profile'][0]->length_category_id != null) {
                    $user['profile'][0]->length_category = DB::table('length_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->length_category_id])
                    ->select('length_categories.value as length_category')
                    ->first()->length_category;
                } else {
                    $user['profile'][0]->length_category = null;
                }

                if ($user['profile'][0]->weight_category_id != null) {
                    $user['profile'][0]->weight_category = DB::table('weight_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->weight_category_id])
                    ->select('weight_categories.value as weight_category')
                    ->first()->weight_category;
                } else {
                    $user['profile'][0]->weight_category = null;
                }

                if ($user['profile'][0]->gender == 'male') {
                    $user['profile'][0]->gender_title = "ذكر";
                } else {
                    $user['profile'][0]->gender_title = "أنثى";
                }

                $Conversations = DB::table('convsersations')
                ->where(['convsersations.to_user_id' => $id])
                ->orWhere(['convsersations.from_user_id' => $id])
                ->get();
                $MessagesCount = 0;
                for ($i = 0; $i < sizeof($Conversations); $i++) {
                    if ($Conversations[$i]->deleted_at == null) {

                        $ConversationDetails = DB::table('conversation_info')
                        ->where('conversation_info.from_id', '<>', $id)
                        ->where(['conversation_info.deleted_at' => null])
                        ->where(['conversation_info.seen_to' => null])
                        ->where(['conversation_info.conversation_id' => $Conversations[$i]->id])
                        ->get();
                        if (sizeof($ConversationDetails) > 0) {
                            $MessagesCount = $MessagesCount + sizeof($ConversationDetails);
                        }
                    }

                }
                $user['profile'][0]->new_messsages_count = $MessagesCount;

                $user['profile'][0]->new_likes_count = DB::table('user_application_likes')
                ->where(['user_application_likes.deleted_at' => null, 'user_application_likes.seen_at' => null, 'user_application_likes.user_id' => $id])
                ->count();
                $user['profile'][0]->new_visitors_count = DB::table('user_application_visitors')
                ->where(['user_application_visitors.deleted_at' => null, 'user_application_visitors.seen_at' => null, 'user_application_visitors.user_id' => $id])
                ->count();


            } else {
                $message = "كلمة المرور المدخلة خاطئة.";
                $user = null;
            }
        } else {
            $message = "عذراً، اسم المستخدم المدخل غير موجود لدينا.";
            $user = null;
        }

        return response(array("status" => $success, "message" => $message, "data" => $user), \Illuminate\Http\Response::HTTP_OK);
    });

Route::post('register', function (Request $request) {
    $success = false;
    $data = null;
    $message = "أهلا وسهلا بك معنا.";
    $input = $request->all();
    $communicationWayIds = $input['communication_way_ids'];

    $haveSons = DB::table('cats')->where(['key' => 'HAVE_SONS'])->select('value')->get();

    for ($i = 0; $i < sizeof($haveSons); $i++) {
        $newHaveSons[] = $haveSons[$i]->value;
    }
    $validator = Validator::make($request->all(), [
        'username' => ['required', 'min:5', Rule::unique('application_users')],
        'name' => ['nullable', 'min:2'],
        'mobile' => ['nullable', 'required', 'numeric', Rule::unique('application_users'), 'digits_between:9,10'],
        'email' => ['required', Rule::unique('application_users'), 'email'],
        'password' => 'required|min:6',
        'biography' => 'nullable|min:30',
        'partner_biography' => 'nullable|min:30',
        'gender' => [
            'required',
            Rule::in(['male', 'female']),
        ],
        'registration_aim_id' => ['required', 'nullable', 'exists:registration_aims,id'],
        'age_id' => ['nullable', 'exists:ages,id'],
        'educational_qualification_id' => ['exists:educational_qualifications,id'],
        'country_code' => ['required', 'exists:countries,code'],
        'nationality_code' => ['nullable', 'exists:nationalities,code'],
        'social_status_id' => ['nullable', 'exists:social_statuses,id'],
        'occupation_id' => ['nullable', 'exists:occupations,id'],
        'eye_color_id' => ['nullable', 'exists:eye_colors,id'],
        'hair_color_id' => ['nullable', 'exists:hair_colors,id'],
        'skin_color_id' => ['nullable', 'exists:skin_colors,id'],
        'length_category_id' => ['nullable', 'exists:length_categories,id'],
        'weight_category_id' => ['nullable', 'exists:weight_categories,id'],
        'have_sons' => ['nullable', Rule::in($newHaveSons)]
    ]
    , [
        'username.required' => 'اسم المستخدم حقل مطلوب',
        'username.min' => 'يجب أن يكون اسم المستخدم على الأقل من خمسة أحرف',
        'name.min' => 'يجب أن يكون الاسم على الأقل من حرفين',
        'username.unique' => 'اسم المستخدم المدخل مستخدم من قبل',
        'email.required' => 'البريد الالكتروني حقل مطلوب',
        'email.email' => 'يجب أن يكون البريد الالكتروني صحيح',
        'email.unique' => 'البريد الالكتروني المدخل مستخدم من قبل',
        'password.required' => 'حقل كلمة المرور مطلوب',
        'password.min' => 'يجب أن تكون كلمة المرور على الأقل من ستة أحرف',
        'biography.min' => 'تحدث عن نفسك تتكون على الأقل من 30 حرف',
        'partner_biography.min' => 'تحدث عن شريكك تتكون على الأقل من 30 حرف',
        'gender.required' => 'حقل الجنس مطلوب',
        'gender.in' => 'لقد اخترت جنس خاطئ',
        'registration_aim_id.required' => 'يجب اختيار الهدف من التسجيل',
        'registration_aim_id.exists' => 'الرجاء اختيار هدف من القائمة',
        'age_id.exists' => 'الرجاء اختيار عمر من القائمة',
        'country_code.required' => 'حقل الدولة مطلوب',
        'country_code.exists' => 'الرجاء اختيار دولة من القائمة',
        'educational_qualification_id.exists' => 'الرجاء اختيار تحصيل علمي من القائمة',
        'nationality_code.exists' => 'الرجاء اختيار جنسية من القائمة',
        'social_status_id.exists' => 'الرجاء اختيار الحالة الاجتماعية من القائمة',
        'have_sons.exists' => 'الرجاء اختيار هل لديك أبناء من القائمة',
        'occupation_id.exists' => 'الرجاء اختيار المهنة من القائمة',
        'eye_color_id.exists' => 'الرجاء اختيار لون العين من القائمة',
        'hair_color_id.exists' => 'الرجاء اختيار لون الشعر من القائمة',
        'skin_color_id.exists' => 'الرجاء اختيار لون البشرة من القائمة',
        'length_category_id.exists' => 'الرجاء اختيار الطول من القائمة',
        'weight_category_id.exists' => 'الرجاء اختيار الوزن من القائمة',
        'mobile.required' => 'رقم الجوال مطلوب',
        'mobile.unique' => 'رقم الجوال المدخل مستخدم من قبل',
        'mobile.numeric' => 'رقم الجوال يتكون من أرقام فقط',
        'mobile.digits_between' => 'لا يجب أن يزيد رقم الجوال عن 10 أرقام ولا يقل عن 9 ( بدون الرمز البريدي للدولة )',

    ]);
    if ($validator->fails()) {
        $message = $validator->errors()->first();
    } else {
        $success = true;
        

        if ($success) {

            if (empty($input['image'])) {
                if ($input['gender'] == 'male') {
                    $image = 'uploads/avatar/male_avatar.png';
                } else {
                    $image = 'uploads/avatar/female_avatar.png';
                }

            } else {
                    // requires php5
                define('UPLOAD_DIR', 'profiles/');
                $img = $input['image'];
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $dataOfImage = base64_decode($img);
                $file = UPLOAD_DIR . uniqid() . '.png';
                $isSuccess = file_put_contents($file, $dataOfImage);
                if ($isSuccess) {
                    $image = $file;
                } else {
                    if ($input['gender'] == 'male') {
                        $image = 'uploads/avatar/male_avatar.png';
                    } else {
                        $image = 'uploads/avatar/female_avatar.png';
                    }
                }
            }

            $insertArray = array('username' => $input['username'],
                'email' => $input['email'],
                'name' => $input['name'],
                'password' => Hash::make($input['password']),
                'gender' => $input['gender'],
                'registration_aim_id' => $input['registration_aim_id'],
                'country_code' => $input['country_code'],
                'mobile' => $input['mobile'],
                'image' => $image);


            if (!empty($input['nationality_code'])) {
                $insertArray['nationality_code'] = $input['nationality_code'];
            }

            if (!empty($input['age_id'])) {
                $insertArray['age_id'] = $input['age_id'];
            }

            if (!empty($input['educational_qualification_id'])) {
                $insertArray['educational_qualification_id'] = $input['educational_qualification_id'];
            }

            if (!empty($input['eye_color_id'])) {
                $insertArray['eye_color_id'] = $input['eye_color_id'];
            }

            if (!empty($input['skin_color_id'])) {
                $insertArray['skin_color_id'] = $input['skin_color_id'];
            }

            if (!empty($input['hair_color_id'])) {
                $insertArray['hair_color_id'] = $input['hair_color_id'];
            }


            if (!empty($input['social_status_id'])) {
                $insertArray['social_status_id'] = $input['social_status_id'];
            }

            if (!empty($input['occupation_id'])) {
                $insertArray['occupation_id'] = $input['occupation_id'];
            }

            if (!empty($input['length_category_id'])) {
                $insertArray['length_category_id'] = $input['length_category_id'];
            }

            if (!empty($input['weight_category_id'])) {
                $insertArray['weight_category_id'] = $input['weight_category_id'];
            }

            if (!empty($input['communication_way_ids'])) {
                $insertArray['communication_way_ids'] = $input['communication_way_ids'];
            }

            if (!empty($input['have_sons'])) {
                $insertArray['have_sons'] = $input['have_sons'];
            }

            if (!empty($input['biography'])) {
                $insertArray['biography'] = $input['biography'];
            }

            if (!empty($input['partner_biography'])) {
                $insertArray['partner_biography'] = $input['partner_biography'];
            }


            $id = DB::table('application_users')->insertGetId(
                $insertArray
            );

            $user['profile'] = DB::table('application_users')
            ->where('application_users.status', '<>', 'banded')
            ->where(['application_users.deleted_at' => null, 'application_users.id' => $id])
            ->join('countries', 'application_users.country_code', '=', 'countries.code')
            ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
            ->select('application_users.*', 'countries.ar_name as country_name', 'registration_aims.value as registration_aim')
            ->get();
            $user['application_user_images'] = DB::table('application_user_images')
            ->where(['deleted_at' => null, 'application_user_id' => $id])
            ->get();
            DB::table('application_users')
            ->where('id', $id)
            ->update(['last_seen' => Carbon::now()->toDateTimeString()]);

                /**********************************
                 * change image url
                 **********************************/
                $user['profile'][0]->image = "http://awa.m-apps.co/" . $user['profile'][0]->image;
                foreach ($user['application_user_images'] as $userImage) {
                    $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
                }

                if ($user['profile'][0]->isPay != 0) {
                    $user['profile'][0]->subscription_id = DB::table('banks_transfers')
                    ->where(['deleted_at' => null, 'user_id' => $id])
                    ->first()->subscription_id;
                } else{
                    $user['profile'][0]->subscription_id = 3;
                }

                if ($user['profile'][0]->nationality_code != null) {
                    $user['profile'][0]->nationality_name = DB::table('nationalities')
                    ->where(['deleted_at' => null, 'code' => $user['profile'][0]->nationality_code])
                    ->select('nationalities.ar_name as nationality_name')
                    ->first()->nationality_name;
                } else {
                    $user['profile'][0]->nationality_name = null;
                }

                if ($user['profile'][0]->age_id != null) {
                    $user['profile'][0]->age = DB::table('ages')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->age_id])
                    ->select('ages.value as age')
                    ->first()->age;
                } else {
                    $user['profile'][0]->age = null;
                }

                if ($user['profile'][0]->educational_qualification_id != null) {
                    $user['profile'][0]->educational_qualification = DB::table('educational_qualifications')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->educational_qualification_id])
                    ->select('educational_qualifications.value as educational_qualification')
                    ->first()->educational_qualification;
                } else {
                    $user['profile'][0]->educational_qualification = null;
                }

                if ($user['profile'][0]->eye_color_id != null) {
                    $user['profile'][0]->eye_color = DB::table('eye_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->eye_color_id])
                    ->select('eye_colors.value as eye_color')
                    ->first()->eye_color;
                } else {
                    $user['profile'][0]->eye_color = null;
                }

                if ($user['profile'][0]->skin_color_id != null) {
                    $user['profile'][0]->skin_color = DB::table('skin_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->skin_color_id])
                    ->select('skin_colors.value as skin_color')
                    ->first()->skin_color;
                } else {
                    $user['profile'][0]->skin_color = null;
                }

                if ($user['profile'][0]->hair_color_id != null) {
                    $user['profile'][0]->hair_color = DB::table('hair_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->hair_color_id])
                    ->select('hair_colors.value as hair_color')
                    ->first()->hair_color;
                } else {
                    $user['profile'][0]->hair_color = null;
                }


                if ($user['profile'][0]->social_status_id != null) {
                    $user['profile'][0]->social_status = DB::table('social_statuses')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->social_status_id])
                    ->select('social_statuses.value as social_status')
                    ->first()->social_status;
                } else {
                    $user['profile'][0]->social_status = null;
                }

                if ($user['profile'][0]->occupation_id != null) {
                    $user['profile'][0]->occupation = DB::table('occupations')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->occupation_id])
                    ->select('occupations.value as occupation')
                    ->first()->occupation;
                } else {
                    $user['profile'][0]->occupation = null;
                }

                if ($user['profile'][0]->length_category_id != null) {
                    $user['profile'][0]->length_category = DB::table('length_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->length_category_id])
                    ->select('length_categories.value as length_category')
                    ->first()->length_category;
                } else {
                    $user['profile'][0]->length_category = null;
                }

                if ($user['profile'][0]->weight_category_id != null) {
                    $user['profile'][0]->weight_category = DB::table('weight_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->weight_category_id])
                    ->select('weight_categories.value as weight_category')
                    ->first()->weight_category;
                } else {
                    $user['profile'][0]->weight_category = null;
                }

                if ($user['profile'][0]->gender == 'male') {
                    $user['profile'][0]->gender_title = "ذكر";
                } else {
                    $user['profile'][0]->gender_title = "أنثى";
                }


                $Conversations = DB::table('convsersations')
                ->where(['convsersations.to_user_id' => $id])
                ->orWhere(['convsersations.from_user_id' => $id])
                ->get();
                $MessagesCount = 0;
                for ($i = 0; $i < sizeof($Conversations); $i++) {
                    if ($Conversations[$i]->deleted_at == null) {

                        $ConversationDetails = DB::table('conversation_info')
                        ->where('conversation_info.from_id', '<>', $id)
                        ->where(['conversation_info.deleted_at' => null])
                        ->where(['conversation_info.seen_to' => null])
                        ->where(['conversation_info.conversation_id' => $Conversations[$i]->id])
                        ->get();
                        if (sizeof($ConversationDetails) > 0) {
                            $MessagesCount = $MessagesCount + sizeof($ConversationDetails);
                        }
                    }

                }
                $user['profile'][0]->new_messsages_count = $MessagesCount;

                $user['profile'][0]->new_likes_count = DB::table('user_application_likes')
                ->where(['user_application_likes.deleted_at' => null, 'user_application_likes.seen_at' => null, 'user_application_likes.user_id' => $id])
                ->count();
                $user['profile'][0]->new_visitors_count = DB::table('user_application_visitors')
                ->where(['user_application_visitors.deleted_at' => null, 'user_application_visitors.seen_at' => null, 'user_application_visitors.user_id' => $id])
                ->count();


                $data = $user;

            }

        }

        return response(array("status" => $success, "message" => $message, "data" => $data), \Illuminate\Http\Response::HTTP_OK);

    });

Route::post('changePassword', function (Request $request) {
    $isFound = false;
    $success = false;
    $message = "تم تغيير كلمة المرور بنجاح";
    $input = $request->all();
    $user = DB::table('application_users')
    ->where(['application_users.deleted_at' => null])
    ->where(['application_users.id' => $input['user_id']])
    ->get();
    if (count($user) == 1) {
        $isFound = true;
    }

    if ($isFound) {
        if (Hash::check($input['password'], $user[0]->password)) {
            $success = true;
            $id = $user[0]->id;
            $user = null;
            DB::table('application_users')
            ->where('id', $id)
            ->update(['password' => Hash::make($input['new_password'])]);

            $user['profile'] = DB::table('application_users')
            ->where('application_users.status', '<>', 'banded')
            ->where(['application_users.deleted_at' => null, 'application_users.id' => $id])
            ->join('countries', 'application_users.country_code', '=', 'countries.code')
            ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
            ->select('application_users.*', 'countries.ar_name as country_name', 'registration_aims.value as registration_aim')
            ->get();
            $user['application_user_images'] = DB::table('application_user_images')
            ->where(['deleted_at' => null, 'application_user_id' => $id])
            ->get();

                /**********************************
                 * change image url
                 **********************************/
                $user['profile'][0]->image = "http://awa.m-apps.co/" . $user['profile'][0]->image;
                foreach ($user['application_user_images'] as $userImage) {
                    $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
                }

                if ($user['profile'][0]->nationality_code != null) {
                    $user['profile'][0]->nationality_name = DB::table('nationalities')
                    ->where(['deleted_at' => null, 'code' => $user['profile'][0]->nationality_code])
                    ->select('nationalities.ar_name as nationality_name')
                    ->first()->nationality_name;
                } else {
                    $user['profile'][0]->nationality_name = null;
                }

                if ($user['profile'][0]->age_id != null) {
                    $user['profile'][0]->age = DB::table('ages')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->age_id])
                    ->select('ages.value as age')
                    ->first()->age;
                } else {
                    $user['profile'][0]->age = null;
                }

                if ($user['profile'][0]->educational_qualification_id != null) {
                    $user['profile'][0]->educational_qualification = DB::table('educational_qualifications')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->educational_qualification_id])
                    ->select('educational_qualifications.value as educational_qualification')
                    ->first()->educational_qualification;
                } else {
                    $user['profile'][0]->educational_qualification = null;
                }

                if ($user['profile'][0]->eye_color_id != null) {
                    $user['profile'][0]->eye_color = DB::table('eye_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->eye_color_id])
                    ->select('eye_colors.value as eye_color')
                    ->first()->eye_color;
                } else {
                    $user['profile'][0]->eye_color = null;
                }

                if ($user['profile'][0]->skin_color_id != null) {
                    $user['profile'][0]->skin_color = DB::table('skin_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->skin_color_id])
                    ->select('skin_colors.value as skin_color')
                    ->first()->skin_color;
                } else {
                    $user['profile'][0]->skin_color = null;
                }

                if ($user['profile'][0]->hair_color_id != null) {
                    $user['profile'][0]->hair_color = DB::table('hair_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->hair_color_id])
                    ->select('hair_colors.value as hair_color')
                    ->first()->hair_color;
                } else {
                    $user['profile'][0]->hair_color = null;
                }


                if ($user['profile'][0]->social_status_id != null) {
                    $user['profile'][0]->social_status = DB::table('social_statuses')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->social_status_id])
                    ->select('social_statuses.value as social_status')
                    ->first()->social_status;
                } else {
                    $user['profile'][0]->social_status = null;
                }

                if ($user['profile'][0]->occupation_id != null) {
                    $user['profile'][0]->occupation = DB::table('occupations')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->occupation_id])
                    ->select('occupations.value as occupation')
                    ->first()->occupation;
                } else {
                    $user['profile'][0]->occupation = null;
                }

                if ($user['profile'][0]->length_category_id != null) {
                    $user['profile'][0]->length_category = DB::table('length_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->length_category_id])
                    ->select('length_categories.value as length_category')
                    ->first()->length_category;
                } else {
                    $user['profile'][0]->length_category = null;
                }

                if ($user['profile'][0]->weight_category_id != null) {
                    $user['profile'][0]->weight_category = DB::table('weight_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->weight_category_id])
                    ->select('weight_categories.value as weight_category')
                    ->first()->weight_category;
                } else {
                    $user['profile'][0]->weight_category = null;
                }

                if ($user['profile'][0]->gender == 'male') {
                    $user['profile'][0]->gender_title = "ذكر";
                } else {
                    $user['profile'][0]->gender_title = "أنثى";
                }

                $Conversations = DB::table('convsersations')
                ->where(['convsersations.to_user_id' => $input['user_id']])
                ->orWhere(['convsersations.from_user_id' => $input['user_id']])
                ->get();
                $MessagesCount = 0;
                for ($i = 0; $i < sizeof($Conversations); $i++) {
                    if ($Conversations[$i]->deleted_at == null) {

                        $ConversationDetails = DB::table('conversation_info')
                        ->where('conversation_info.from_id', '<>', $input['user_id'])
                        ->where(['conversation_info.deleted_at' => null])
                        ->where(['conversation_info.seen_to' => null])
                        ->where(['conversation_info.conversation_id' => $Conversations[$i]->id])
                        ->get();
                        if (sizeof($ConversationDetails) > 0) {
                            $MessagesCount = $MessagesCount + sizeof($ConversationDetails);
                        }
                    }

                }
                $user['profile'][0]->new_messsages_count = $MessagesCount;

                $user['profile'][0]->new_likes_count = DB::table('user_application_likes')
                ->where(['user_application_likes.deleted_at' => null, 'user_application_likes.seen_at' => null, 'user_application_likes.user_id' => $input['user_id']])
                ->count();
                $user['profile'][0]->new_visitors_count = DB::table('user_application_visitors')
                ->where(['user_application_visitors.deleted_at' => null, 'user_application_visitors.seen_at' => null, 'user_application_visitors.user_id' => $input['user_id']])
                ->count();


            } else {
                $message = "كلمة المرور المدخلة خاطئة.";
                $user = null;
            }
        } else {
            $message = "عذراً، اسم المستخدم المدخل غير موجود لدينا.";
            $user = null;
        }

        DB::table('application_users')
        ->where('id', $input['user_id'])
        ->update(['last_seen' => Carbon::now()->toDateTimeString()]);

        return response(array("status" => $success, "message" => $message, "data" => $user), \Illuminate\Http\Response::HTTP_OK);
    });


Route::post('updateProfile', function (Request $request) {
    $success = false;
    $data = null;
    $message = "تم تحديث البيانات بنجاح.";
    $input = $request->all();
    $communicationWayIds = explode(";", $input['communication_way_ids']);

    $haveSons = DB::table('cats')->where(['key' => 'HAVE_SONS'])->select('value')->get();

    for ($i = 0; $i < sizeof($haveSons); $i++) {
        $newHaveSons[] = $haveSons[$i]->value;
    }
    $validator = Validator::make($request->all(), [
        'user_id' => ['required', Rule::exists('application_users', 'id')],
        'name' => ['nullable', 'min:2'],
        'mobile' => ['nullable', 'required', 'numeric', Rule::unique('application_users')->ignore($request->input("user_id")), 'digits_between:9,10'],
        'email' => ['required', Rule::unique('application_users')->ignore($request->input("user_id")), 'email'],
        'biography' => 'nullable|min:30',
        'partner_biography' => 'nullable|min:30',
        'gender' => [
            'required',
            Rule::in(['male', 'female']),
        ],
        'registration_aim_id' => ['required', 'nullable', 'exists:registration_aims,id'],
        'age_id' => ['nullable', 'exists:ages,id'],
        'educational_qualification_id' => ['exists:educational_qualifications,id'],
        'country_code' => ['required', 'exists:countries,code'],
        'nationality_code' => ['nullable', 'exists:nationalities,code'],
        'social_status_id' => ['nullable', 'exists:social_statuses,id'],
        'occupation_id' => ['nullable', 'exists:occupations,id'],
        'eye_color_id' => ['nullable', 'exists:eye_colors,id'],
        'hair_color_id' => ['nullable', 'exists:hair_colors,id'],
        'skin_color_id' => ['nullable', 'exists:skin_colors,id'],
        'length_category_id' => ['nullable', 'exists:length_categories,id'],
        'weight_category_id' => ['nullable', 'exists:weight_categories,id'],
        'have_sons' => ['nullable', Rule::in($newHaveSons)]
    ]
    , [
        'user_id.required' => 'حقل رقم المستخدم حقل مطلوب',
        'user_id.exists' => 'حقل رقم المستخدم المدخل غير موجود',
        'name.min' => 'يجب أن يكون الاسم على الأقل من حرفين',
        'email.required' => 'البريد الالكتروني حقل مطلوب',
        'email.email' => 'يجب أن يكون البريد الالكتروني صحيح',
        'email.unique' => 'البريد الالكتروني المدخل مستخدم من قبل',
        'biography.min' => 'تحدث عن نفسك تتكون على الأقل من 30 حرف',
        'partner_biography.min' => 'تحدث عن شريكك تتكون على الأقل من 30 حرف',
        'gender.required' => 'حقل الجنس مطلوب',
        'gender.in' => 'لقد اخترت جنس خاطئ',
        'registration_aim_id.exists' => 'الرجاء اختيار هدف من القائمة',
        'age_id.exists' => 'الرجاء اختيار عمر من القائمة',
        'country_code.required' => 'حقل الدولة مطلوب',
        'country_code.exists' => 'الرجاء اختيار دولة من القائمة',
        'educational_qualification_id.exists' => 'الرجاء اختيار تحصيل علمي من القائمة',
        'nationality_code.exists' => 'الرجاء اختيار جنسية من القائمة',
        'social_status_id.exists' => 'الرجاء اختيار الحالة الاجتماعية من القائمة',
        'have_sons.exists' => 'الرجاء اختيار هل لديك أبناء من القائمة',
        'occupation_id.exists' => 'الرجاء اختيار المهنة من القائمة',
        'eye_color_id.exists' => 'الرجاء اختيار لون العين من القائمة',
        'hair_color_id.exists' => 'الرجاء اختيار لون الشعر من القائمة',
        'skin_color_id.exists' => 'الرجاء اختيار لون البشرة من القائمة',
        'length_category_id.exists' => 'الرجاء اختيار الطول من القائمة',
        'weight_category_id.exists' => 'الرجاء اختيار الوزن من القائمة',
        'mobile.required' => 'رقم الجوال مطلوب',
        'mobile.unique' => 'رقم الجوال المدخل مستخدم من قبل',
        'mobile.numeric' => 'رقم الجوال يتكون من أرقام فقط',
        'mobile.digits' => 'لا يجب أن يزيد رقم الجوال عن 10 أرقام ولا يقل عن 9 ( بدون الرمز البريدي للدولة )',
        'mobile.digits_between' => 'لا يجب أن يزيد رقم الجوال عن 10 أرقام ولا يقل عن 9 ( بدون الرمز البريدي للدولة )',

    ]);
    if ($validator->fails()) {
        $message = $validator->errors()->first();
    } else {
        $success = true;
        if ($communicationWayIds > 0 && !empty($communicationWayIds[0])) {
            for ($i = 0; $i < sizeof($communicationWayIds); $i++) {
                $count = DB::table('communication_ways')->where(
                    ['value' => $communicationWayIds[$i]]
                )->count();
                if ($count != 1) {
                    $success = false;
                    $message = "الرجاء اختيار طريقة تواصل من القائمة";
                    break;
                }
            }
        }

        if ($success) {

            if (empty($input['image'])) {
                if ($input['gender'] == 'male') {
                    $image = 'uploads/avatar/male_avatar.png';
                } else {
                    $image = 'uploads/avatar/female_avatar.png';
                }

            } else {
                    // requires php5
                define('UPLOAD_DIR', 'profiles/');
                $img = $input['image'];
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $dataOfImage = base64_decode($img);
                $file = UPLOAD_DIR . uniqid() . '.png';
                $isSuccess = file_put_contents($file, $dataOfImage);
                if ($isSuccess) {
                    $image = $file;
                } else {
                    if ($input['gender'] == 'male') {
                        $image = 'uploads/avatar/male_avatar.png';
                    } else {
                        $image = 'uploads/avatar/female_avatar.png';
                    }
                }
            }

            $insertArray = array(
                'email' => $input['email'],
                'name' => $input['name'],
                'gender' => $input['gender'],
                'registration_aim_id' => $input['registration_aim_id'],
                'country_code' => $input['country_code'],
                'mobile' => $input['mobile'],
                'image' => $image);


            if (!empty($input['nationality_code'])) {
                $insertArray['nationality_code'] = $input['nationality_code'];
            }

            if (!empty($input['age_id'])) {
                $insertArray['age_id'] = $input['age_id'];
            }

            if (!empty($input['educational_qualification_id'])) {
                $insertArray['educational_qualification_id'] = $input['educational_qualification_id'];
            }

            if (!empty($input['eye_color_id'])) {
                $insertArray['eye_color_id'] = $input['eye_color_id'];
            }

            if (!empty($input['skin_color_id'])) {
                $insertArray['skin_color_id'] = $input['skin_color_id'];
            }

            if (!empty($input['hair_color_id'])) {
                $insertArray['hair_color_id'] = $input['hair_color_id'];
            }


            if (!empty($input['social_status_id'])) {
                $insertArray['social_status_id'] = $input['social_status_id'];
            }

            if (!empty($input['occupation_id'])) {
                $insertArray['occupation_id'] = $input['occupation_id'];
            }

            if (!empty($input['length_category_id'])) {
                $insertArray['length_category_id'] = $input['length_category_id'];
            }

            if (!empty($input['weight_category_id'])) {
                $insertArray['weight_category_id'] = $input['weight_category_id'];
            }

            if (!empty($input['communication_way_ids'])) {
                $insertArray['communication_way_ids'] = $input['communication_way_ids'];
            }

            if (!empty($input['have_sons'])) {
                $insertArray['have_sons'] = $input['have_sons'];
            }

            if (!empty($input['biography'])) {
                $insertArray['biography'] = $input['biography'];
            }

            if (!empty($input['partner_biography'])) {
                $insertArray['partner_biography'] = $input['partner_biography'];
            }


            DB::table('application_users')
            ->where('id', $input['user_id'])
            ->update(
                $insertArray
            );
            $id = $input['user_id'];

            $user['profile'] = DB::table('application_users')
            ->where('application_users.status', '<>', 'banded')
            ->where(['application_users.deleted_at' => null, 'application_users.id' => $id])
            ->join('countries', 'application_users.country_code', '=', 'countries.code')
            ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
            ->select('application_users.*', 'countries.ar_name as country_name', 'registration_aims.value as registration_aim')
            ->get();
            $user['application_user_images'] = DB::table('application_user_images')
            ->where(['deleted_at' => null, 'application_user_id' => $id])
            ->get();

                /**********************************
                 * change image url
                 **********************************/
                $user['profile'][0]->image = "http://awa.m-apps.co/" . $user['profile'][0]->image;
                foreach ($user['application_user_images'] as $userImage) {
                    $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
                }

                if ($user['profile'][0]->nationality_code != null) {
                    $user['profile'][0]->nationality_name = DB::table('nationalities')
                    ->where(['deleted_at' => null, 'code' => $user['profile'][0]->nationality_code])
                    ->select('nationalities.ar_name as nationality_name')
                    ->first()->nationality_name;
                } else {
                    $user['profile'][0]->nationality_name = null;
                }

                if ($user['profile'][0]->age_id != null) {
                    $user['profile'][0]->age = DB::table('ages')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->age_id])
                    ->select('ages.value as age')
                    ->first()->age;
                } else {
                    $user['profile'][0]->age = null;
                }

                if ($user['profile'][0]->educational_qualification_id != null) {
                    $user['profile'][0]->educational_qualification = DB::table('educational_qualifications')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->educational_qualification_id])
                    ->select('educational_qualifications.value as educational_qualification')
                    ->first()->educational_qualification;
                } else {
                    $user['profile'][0]->educational_qualification = null;
                }

                if ($user['profile'][0]->eye_color_id != null) {
                    $user['profile'][0]->eye_color = DB::table('eye_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->eye_color_id])
                    ->select('eye_colors.value as eye_color')
                    ->first()->eye_color;
                } else {
                    $user['profile'][0]->eye_color = null;
                }

                if ($user['profile'][0]->skin_color_id != null) {
                    $user['profile'][0]->skin_color = DB::table('skin_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->skin_color_id])
                    ->select('skin_colors.value as skin_color')
                    ->first()->skin_color;
                } else {
                    $user['profile'][0]->skin_color = null;
                }

                if ($user['profile'][0]->hair_color_id != null) {
                    $user['profile'][0]->hair_color = DB::table('hair_colors')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->hair_color_id])
                    ->select('hair_colors.value as hair_color')
                    ->first()->hair_color;
                } else {
                    $user['profile'][0]->hair_color = null;
                }


                if ($user['profile'][0]->social_status_id != null) {
                    $user['profile'][0]->social_status = DB::table('social_statuses')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->social_status_id])
                    ->select('social_statuses.value as social_status')
                    ->first()->social_status;
                } else {
                    $user['profile'][0]->social_status = null;
                }

                if ($user['profile'][0]->occupation_id != null) {
                    $user['profile'][0]->occupation = DB::table('occupations')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->occupation_id])
                    ->select('occupations.value as occupation')
                    ->first()->occupation;
                } else {
                    $user['profile'][0]->occupation = null;
                }

                if ($user['profile'][0]->length_category_id != null) {
                    $user['profile'][0]->length_category = DB::table('length_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->length_category_id])
                    ->select('length_categories.value as length_category')
                    ->first()->length_category;
                } else {
                    $user['profile'][0]->length_category = null;
                }

                if ($user['profile'][0]->weight_category_id != null) {
                    $user['profile'][0]->weight_category = DB::table('weight_categories')
                    ->where(['deleted_at' => null, 'id' => $user['profile'][0]->weight_category_id])
                    ->select('weight_categories.value as weight_category')
                    ->first()->weight_category;
                } else {
                    $user['profile'][0]->weight_category = null;
                }

                if ($user['profile'][0]->gender == 'male') {
                    $user['profile'][0]->gender_title = "ذكر";
                } else {
                    $user['profile'][0]->gender_title = "أنثى";
                }

                $Conversations = DB::table('convsersations')
                ->where(['convsersations.to_user_id' => $input['user_id']])
                ->orWhere(['convsersations.from_user_id' => $input['user_id']])
                ->get();
                $MessagesCount = 0;
                for ($i = 0; $i < sizeof($Conversations); $i++) {
                    if ($Conversations[$i]->deleted_at == null) {

                        $ConversationDetails = DB::table('conversation_info')
                        ->where('conversation_info.from_id', '<>', $input['user_id'])
                        ->where(['conversation_info.deleted_at' => null])
                        ->where(['conversation_info.seen_to' => null])
                        ->where(['conversation_info.conversation_id' => $Conversations[$i]->id])
                        ->get();
                        if (sizeof($ConversationDetails) > 0) {
                            $MessagesCount = $MessagesCount + sizeof($ConversationDetails);
                        }
                    }

                }
                $user['profile'][0]->new_messsages_count = $MessagesCount;

                $user['profile'][0]->new_likes_count = DB::table('user_application_likes')
                ->where(['user_application_likes.deleted_at' => null, 'user_application_likes.seen_at' => null, 'user_application_likes.user_id' => $input['user_id']])
                ->count();
                $user['profile'][0]->new_visitors_count = DB::table('user_application_visitors')
                ->where(['user_application_visitors.deleted_at' => null, 'user_application_visitors.seen_at' => null, 'user_application_visitors.user_id' => $input['user_id']])
                ->count();


                $data = $user;

            }

        }

        DB::table('application_users')
        ->where('id', $input['user_id'])
        ->update(['last_seen' => Carbon::now()->toDateTimeString()]);

        return response(array("status" => $success, "message" => $message, "data" => $data), \Illuminate\Http\Response::HTTP_OK);

    });


Route::post('updatedImages', function (Request $request) {
    $success = false;
    $data = null;
    $message = "تم تحديث صورك الشخصية بنجاح.";
    $input = $request->all();


    $image_one = NULL;
    $image_two = NULL;
    $image_three = NULL;
    if (!empty($input['image_one'])) {
            // requires php5
        define('UPLOAD_DIR', 'profiles/');
        $img = $input['image_one'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $dataOfImage = base64_decode($img);
        $file = UPLOAD_DIR . uniqid() . '.png';
        file_put_contents($file, $dataOfImage);
        $image_one = $file;


    }

    if (!empty($input['image_two'])) {
        // requires php5
      define('UPLOAD_DIR', 'profiles/');
      $img = $input['image_two'];
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $dataOfImage = base64_decode($img);
      $file = UPLOAD_DIR . uniqid() . '.png';
      file_put_contents($file, $dataOfImage);
      $image_two = $file;

  }


  if (!empty($input['image_three'])) {
        // requires php5
   define('UPLOAD_DIR', 'profiles/');
   $img = $input['image_three'];
   $img = str_replace('data:image/png;base64,', '', $img);
   $img = str_replace(' ', '+', $img);
   $dataOfImage = base64_decode($img);
   $file = UPLOAD_DIR . uniqid() . '.png';
   file_put_contents($file, $dataOfImage);
   $image_three = $file;

}

$images = DB::table('application_user_images')
->where('application_user_images.deleted_at', '=', null)
->where('application_user_images.application_user_id', '=', $input['user_id'])->get();


if (sizeof($images) > 0) {
    if (sizeof($images) == 1) {
        if ($image_one != null) {
            $insertArray = array(
                'application_user_id' => $input['user_id'],
                'image' => $image_one,
            );
            DB::table('application_user_images')
            ->where('id', $id)
            ->update(
                $insertArray
            );
        }
        if ($image_two != null) {

            $insertArray = array(
                'application_user_id' => $input['user_id'],
                'image' => $image_two,
            );
            DB::table('application_user_images')->insert(
                $insertArray
            );
        }
        if ($image_three != null) {
            $insertArray = array(
                'application_user_id' => $input['user_id'],
                'image' => $image_three,
            );
            DB::table('application_user_images')->insert(
                $insertArray
            );
        }

    } else if (sizeof($images) == 2) {
        if ($image_one != null) {
            $id = $images[0]->id;
            $insertArray = array(
                'application_user_id' => $input['user_id'],
                'image' => $image_one,
            );
            DB::table('application_user_images')
            ->where('id', $id)
            ->update(
                $insertArray
            );
        }
        if ($image_two != null) {
            $id = $images[1]->id;
            $insertArray = array(
                'application_user_id' => $input['user_id'],
                'image' => $image_two,
            );
            DB::table('application_user_images')
            ->where('id', $id)
            ->update(
                $insertArray
            );
        }

        if ($image_three != null) {
            $insertArray = array(
                'application_user_id' => $input['user_id'],
                'image' => $image_three,
            );
            DB::table('application_user_images')->insert(
                $insertArray
            );
        }
    } else if (sizeof($images) == 3) {
        if ($image_one != null) {
            $id = $images[0]->id;
            $insertArray = array(
                'application_user_id' => $input['user_id'],
                'image' => $image_one,
            );
            DB::table('application_user_images')
            ->where('id', $id)
            ->update(
                $insertArray
            );
        }
        if ($image_two != null) {
            $id = $images[1]->id;
            $insertArray = array(
                'application_user_id' => $input['user_id'],
                'image' => $image_two,
            );
            DB::table('application_user_images')
            ->where('id', $id)
            ->update(
                $insertArray
            );
        }
        if ($image_three != null) {
            $id = $images[2]->id;
            $insertArray = array(
                'application_user_id' => $input['user_id'],
                'image' => $image_three,
            );
            DB::table('application_user_images')
            ->where('id', $id)
            ->update(
                $insertArray
            );
        }
    }
} else {

    if ($image_one != null) {
        $insertArray = array(
            'application_user_id' => $input['user_id'],
            'image' => $image_one,
        );
        DB::table('application_user_images')->insert(
            $insertArray
        );
    }
    if ($image_two != null) {

        $insertArray = array(
            'application_user_id' => $input['user_id'],
            'image' => $image_two,
        );
        DB::table('application_user_images')->insert(
            $insertArray
        );
    }
    if ($image_three != null) {
        $insertArray = array(
            'application_user_id' => $input['user_id'],
            'image' => $image_three,
        );
        DB::table('application_user_images')->insert(
            $insertArray
        );
    }
}

$id = $input['user_id'];
$user['profile'] = DB::table('application_users')
->where('application_users.status', '<>', 'banded')
->where(['application_users.deleted_at' => null, 'application_users.id' => $id])
->join('countries', 'application_users.country_code', '=', 'countries.code')
->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
->select('application_users.*', 'countries.ar_name as country_name', 'registration_aims.value as registration_aim')
->get();
$user['application_user_images'] = DB::table('application_user_images')
->where(['deleted_at' => null, 'application_user_id' => $id])
->get();

        /**********************************
         * change image url
         **********************************/
        $user['profile'][0]->image = "http://awa.m-apps.co/" . $user['profile'][0]->image;
        foreach ($user['application_user_images'] as $userImage) {
            $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
        }

        if ($user['profile'][0]->nationality_code != null) {
            $user['profile'][0]->nationality_name = DB::table('nationalities')
            ->where(['deleted_at' => null, 'code' => $user['profile'][0]->nationality_code])
            ->select('nationalities.ar_name as nationality_name')
            ->first()->nationality_name;
        } else {
            $user['profile'][0]->nationality_name = null;
        }

        if ($user['profile'][0]->age_id != null) {
            $user['profile'][0]->age = DB::table('ages')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->age_id])
            ->select('ages.value as age')
            ->first()->age;
        } else {
            $user['profile'][0]->age = null;
        }

        if ($user['profile'][0]->educational_qualification_id != null) {
            $user['profile'][0]->educational_qualification = DB::table('educational_qualifications')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->educational_qualification_id])
            ->select('educational_qualifications.value as educational_qualification')
            ->first()->educational_qualification;
        } else {
            $user['profile'][0]->educational_qualification = null;
        }

        if ($user['profile'][0]->eye_color_id != null) {
            $user['profile'][0]->eye_color = DB::table('eye_colors')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->eye_color_id])
            ->select('eye_colors.value as eye_color')
            ->first()->eye_color;
        } else {
            $user['profile'][0]->eye_color = null;
        }

        if ($user['profile'][0]->skin_color_id != null) {
            $user['profile'][0]->skin_color = DB::table('skin_colors')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->skin_color_id])
            ->select('skin_colors.value as skin_color')
            ->first()->skin_color;
        } else {
            $user['profile'][0]->skin_color = null;
        }

        if ($user['profile'][0]->hair_color_id != null) {
            $user['profile'][0]->hair_color = DB::table('hair_colors')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->hair_color_id])
            ->select('hair_colors.value as hair_color')
            ->first()->hair_color;
        } else {
            $user['profile'][0]->hair_color = null;
        }


        if ($user['profile'][0]->social_status_id != null) {
            $user['profile'][0]->social_status = DB::table('social_statuses')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->social_status_id])
            ->select('social_statuses.value as social_status')
            ->first()->social_status;
        } else {
            $user['profile'][0]->social_status = null;
        }

        if ($user['profile'][0]->occupation_id != null) {
            $user['profile'][0]->occupation = DB::table('occupations')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->occupation_id])
            ->select('occupations.value as occupation')
            ->first()->occupation;
        } else {
            $user['profile'][0]->occupation = null;
        }

        if ($user['profile'][0]->length_category_id != null) {
            $user['profile'][0]->length_category = DB::table('length_categories')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->length_category_id])
            ->select('length_categories.value as length_category')
            ->first()->length_category;
        } else {
            $user['profile'][0]->length_category = null;
        }

        if ($user['profile'][0]->weight_category_id != null) {
            $user['profile'][0]->weight_category = DB::table('weight_categories')
            ->where(['deleted_at' => null, 'id' => $user['profile'][0]->weight_category_id])
            ->select('weight_categories.value as weight_category')
            ->first()->weight_category;
        } else {
            $user['profile'][0]->weight_category = null;
        }

        if ($user['profile'][0]->gender == 'male') {
            $user['profile'][0]->gender_title = "ذكر";
        } else {
            $user['profile'][0]->gender_title = "أنثى";
        }

        $Conversations = DB::table('convsersations')
        ->where(['convsersations.to_user_id' => $input['user_id']])
        ->orWhere(['convsersations.from_user_id' => $input['user_id']])
        ->get();
        $MessagesCount = 0;
        for ($i = 0; $i < sizeof($Conversations); $i++) {
            if ($Conversations[$i]->deleted_at == null) {

                $ConversationDetails = DB::table('conversation_info')
                ->where('conversation_info.from_id', '<>', $input['user_id'])
                ->where(['conversation_info.deleted_at' => null])
                ->where(['conversation_info.seen_to' => null])
                ->where(['conversation_info.conversation_id' => $Conversations[$i]->id])
                ->get();
                if (sizeof($ConversationDetails) > 0) {
                    $MessagesCount = $MessagesCount + sizeof($ConversationDetails);
                }
            }

        }
        $user['profile'][0]->new_messsages_count = $MessagesCount;

        $user['profile'][0]->new_likes_count = DB::table('user_application_likes')
        ->where(['user_application_likes.deleted_at' => null, 'user_application_likes.seen_at' => null, 'user_application_likes.user_id' => $input['user_id']])
        ->count();
        $user['profile'][0]->new_visitors_count = DB::table('user_application_visitors')
        ->where(['user_application_visitors.deleted_at' => null, 'user_application_visitors.seen_at' => null, 'user_application_visitors.user_id' => $input['user_id']])
        ->count();

        $data = $user;

        DB::table('application_users')
        ->where('id', $input['user_id'])
        ->update(['last_seen' => Carbon::now()->toDateTimeString()]);



        return response(array("status" => $success, "message" => $message, "data" => $data), \Illuminate\Http\Response::HTTP_OK);

    });

});

Route::post('adminConnection', function (Request $request) {
    $input = $request->all();
    $insertArray = array(
        'from_user_id' => $input['from_user_id'],
        'category' => $input['category'],
        'content' => $input['content']
    );
    DB::table('application_users_connections')->insertGetId(
        $insertArray
    );
    DB::table('application_users')
    ->where('id', $input['from_user_id'])
    ->update(['last_seen' => Carbon::now()->toDateTimeString()]);
    return response(array("status" => true, "message" => "تمت الإضافة بنجاح", "data" => null), \Illuminate\Http\Response::HTTP_OK);


});

Route::get('khatabat', function (Request $request) {
    $Khatabat = DB::table('khatabat')
    ->join('countries', 'khatabat.country_code', '=', 'countries.code')
    ->where(['khatabat.deleted_at' => null])
    ->select('khatabat.*','countries.flag_image')
    ->get();
    foreach ($Khatabat as $userImage) {
        $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
        $userImage->flag_image = "http://awa.m-apps.co/uploads/flags/128x128/" . $userImage->flag_image;
        $userImage->country_name = DB::table('countries')->where(['deleted_at' => null, 'code' => $userImage->country_code])->first()->ar_name;
    }
    return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $Khatabat), \Illuminate\Http\Response::HTTP_OK);
});


Route::get('banks', function (Request $request) {
    $Banks = DB::table('banks')
    ->where(['deleted_at' => null, 'status' => '1'])
    ->get();
    foreach ($Banks as $bankImage) {
        $bankImage->value = $bankImage->name;
        $bankImage->image = "http://awa.m-apps.co/" . $bankImage->image;
    }
    return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $Banks), \Illuminate\Http\Response::HTTP_OK);
});

Route::get('depositMethods', function (Request $request) {
    $depositMethods = DB::table('deposit_methods')
    ->where(['deleted_at' => null, 'status' => '1'])
    ->get();

    return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $depositMethods), \Illuminate\Http\Response::HTTP_OK);
});

Route::get('subscriptions', function (Request $request) {
    $depositMethods = DB::table('subscriptions')
    ->where(['deleted_at' => null])
    ->select('id','title as value','has_messages','has_likes','has_khatabat','price','duration','plus_duration')
    ->get();

    return response(array("status" => true, "message" => "تم الارجاع بنجاح", "data" => $depositMethods), \Illuminate\Http\Response::HTTP_OK);
});

Route::post('sendDepositTransfer', function (Request $request) {
    $input = $request->all();
    $insertArray = array('applicant_name' => $input['applicant_name'],
        'quantity' => $input['quantity'],
        'user_id' => $input['user_id'],
        'deposit_date' => $input['deposit_date'],
        'deposit_account_number' => $input['deposit_account_number'],
        'notes' => $input['notes'],
        'subscription_id' => $input['subscription_id'],
        'deposit_method_id' => $input['deposit_method_id']);
    $id = DB::table('banks_transfers')->insertGetId(
        $insertArray
    );
    $banksTransfer = DB::table('banks_transfers')
    ->where(['deleted_at' => null, 'id' => $id])
    ->get();
    return response(array("status" => true, "message" => "تم الاضافة بنجاح", "data" => $banksTransfer), \Illuminate\Http\Response::HTTP_OK);
});
Route::get('updatedAll', function (Request $request) {
    $application_users = DB::table('application_users')->where(['isPay' => 1])->where('finish_at', '<' , Carbon::now())->get();
    $insertArray = array();
    $insertArray['isPay'] = 0;
    $insertArray['start_at'] = NULL;
    $insertArray['finish_at'] = NULL;
    foreach($application_users as $user){
        DB::table('application_users')
        ->where('id', $user->id)
        ->update(
            $insertArray
        );
    }
});

Route::prefix('search')->group(function () {
    Route::post('advance', function (Request $request) {
        $success = false;
        $data = null;
        $message = "تم ارجاع النتائج بنجاح";
        $input = $request->all();
        $communicationWayIds = explode(";", $input['communication_way_ids']);

        $haveSons = DB::table('cats')->where(['key' => 'HAVE_SONS'])->select('value')->get();

        for ($i = 0; $i < sizeof($haveSons); $i++) {
            $newHaveSons[] = $haveSons[$i]->value;
        }

        $validator = Validator::make($request->all(), [
            'user_id' => ['required', Rule::exists('application_users', 'id')],
            'name' => ['nullable', 'min:2'],
            'gender' => ['nullable',
            Rule::in(['male', 'female']),
        ],
        'registration_aim_id' => ['nullable', 'exists:registration_aims,id'],
        'age_id' => ['nullable', 'exists:ages,id'],
        'educational_qualification_id' => ['nullable', 'exists:educational_qualifications,id'],
        'country_code' => ['nullable', 'exists:countries,code'],
        'nationality_code' => ['nullable', 'exists:nationalities,code'],
        'social_status_id' => ['nullable', 'exists:social_statuses,id'],
        'occupation_id' => ['nullable', 'exists:occupations,id'],
        'eye_color_id' => ['nullable', 'exists:eye_colors,id'],
        'hair_color_id' => ['nullable', 'exists:hair_colors,id'],
        'skin_color_id' => ['nullable', 'exists:skin_colors,id'],
        'length_category_id' => ['nullable', 'exists:length_categories,id'],
        'weight_category_id' => ['nullable', 'exists:weight_categories,id'],
        'have_sons' => ['nullable', Rule::in($newHaveSons)]
    ]
    , [
        'user_id.required' => 'حقل رقم المستخدم حقل مطلوب',
        'user_id.exists' => 'حقل رقم المستخدم المدخل غير موجود',
        'name.min' => 'يجب أن يكون الاسم على الأقل من حرفين',
        'username.unique' => 'اسم المستخدم المدخل مستخدم من قبل',
        'gender.in' => 'لقد اخترت جنس خاطئ',
        'registration_aim_id.exists' => 'الرجاء اختيار هدف من القائمة',
        'age_id.exists' => 'الرجاء اختيار عمر من القائمة',
        'country_code.exists' => 'الرجاء اختيار دولة من القائمة',
        'educational_qualification_id.exists' => 'الرجاء اختيار تحصيل علمي من القائمة',
        'nationality_code.exists' => 'الرجاء اختيار جنسية من القائمة',
        'social_status_id.exists' => 'الرجاء اختيار الحالة الاجتماعية من القائمة',
        'have_sons.exists' => 'الرجاء اختيار هل لديك أبناء من القائمة',
        'occupation_id.exists' => 'الرجاء اختيار المهنة من القائمة',
        'eye_color_id.exists' => 'الرجاء اختيار لون العين من القائمة',
        'hair_color_id.exists' => 'الرجاء اختيار لون الشعر من القائمة',
        'skin_color_id.exists' => 'الرجاء اختيار لون البشرة من القائمة',
        'length_category_id.exists' => 'الرجاء اختيار الطول من القائمة',
        'weight_category_id.exists' => 'الرجاء اختيار الوزن من القائمة',

    ]);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
        } else {
            $success = true;
            

            $query = "SELECT * FROM application_users WHERE deleted_at IS NULL 
            AND id <> '".$input['user_id']."'";

            if(isset($input['name']) && !empty($input['name'])){
                $query = $query . " AND name LIKE  %'".$input['name']."'% ";
            }

            if(isset($input['gender']) && !empty($input['gender'])){
                $query = $query . " AND gender = '".$input['gender']."'";
            }
            if(isset($input['registration_aim_id']) && !empty($input['registration_aim_id'])){
                $query = $query . " AND registration_aim_id = '".$input['registration_aim_id']."'";
            }

            if(isset($input['educational_qualification_id']) && !empty($input['educational_qualification_id'])){
                $query = $query . " AND educational_qualification_id = '".$input['educational_qualification_id']."'";
            }

            if(isset($input['age_id']) && !empty($input['age_id'])){
                $query = $query . " AND age_id = '".$input['age_id']."'";
            }

            if(isset($input['country_code']) && !empty($input['country_code'])){
                $query = $query . " AND country_code = '".$input['country_code']."'";
            }

            if(isset($input['nationality_code']) && !empty($input['nationality_code'])){
                $query = $query . " AND nationality_code = '".$input['nationality_code']."'";
            }
            if(isset($input['social_status_id']) && !empty($input['social_status_id'])){
                $query = $query . " AND social_status_id = '".$input['social_status_id']."'";
            }

            if(isset($input['occupation_id']) && !empty($input['occupation_id'])){
                $query = $query . " AND occupation_id = '".$input['occupation_id']."'";
            }

            if(isset($input['eye_color_id']) && !empty($input['eye_color_id'])){
                $query = $query . " AND eye_color_id = '".$input['eye_color_id']."'";
            }

            if(isset($input['hair_color_id']) && !empty($input['hair_color_id'])){
                $query = $query . " AND hair_color_id = '".$input['hair_color_id']."'";
            }

            if(isset($input['skin_color_id']) && !empty($input['skin_color_id'])){
                $query = $query . " AND skin_color_id = '".$input['skin_color_id']."'";
            }

            if(isset($input['length_category_id']) && !empty($input['length_category_id'])){
                $query = $query . " AND length_category_id = '".$input['length_category_id']."'";
            }

            if(isset($input['weight_category_id']) && !empty($input['weight_category_id'])){
                $query = $query . " AND weight_category_id = '".$input['weight_category_id']."'";
            }

            if(isset($input['have_sons']) && !empty($input['have_sons'])){
                $query = $query . " AND have_sons = '".$input['have_sons']."'";
            }





            if ($communicationWayIds > 0 && !empty($communicationWayIds[0])) {
                for ($i = 0; $i < sizeof($communicationWayIds); $i++) {
                    $count = DB::table('communication_ways')->where(
                        ['value' => $communicationWayIds[$i]]
                    )->count();
                    if ($count != 1) {
                        $success = false;
                        $message = "الرجاء اختيار طريقة تواصل من القائمة";
                        break;
                    }
                }
            }


            
            $user['profile'] = DB::select($query);
            $blocks = DB::table('user_application_blocks')
            ->where(['user_application_blocks.deleted_at' => null, 'user_application_blocks.from_user_id' => $input['user_id']])
            ->join('application_users', 'user_application_blocks.user_id', '=', 'application_users.id')
            ->select('user_application_blocks.user_id')->get();

            $cleanResult = array();
            for ($i = 0; $i < sizeof($user['profile']); $i++) {
                if (!array_key_exists($user['profile'][$i]->id, $cleanResult) && $user['profile'][$i]->deleted_at == null &&
                    $user['profile'][$i]->status != 'banded') {

                    if (sizeof($blocks) > 0) {
                        var_dump($input['currently']);exit;
                        foreach ($blocks as $block) {
                            if ($block->user_id != $user['profile'][$i]->id) {
                                if (!empty($input['currently']) && @$input['currently'] == true) {


                                    if ($user['profile'][$i]->last_seen != null) {
                                        $date1 = new DateTime(date('Y-m-d H:i:s', strtotime($user['profile'][$i]->last_seen)));
                                        $date2 = new DateTime(date('Y-m-d H:i:s'));
                                        $interval = $date1->diff($date2);
                                        $hours = ($interval->days * 24) + $interval->h
                                        + ($interval->i / 60) + ($interval->s / 3600);

                                        if ($hours < 24) {
                                            $cleanResult[] = $user['profile'][$i];
                                        }

                                    }
                                } else if (!empty($input['last_seen'])) {
                                    if ($input['last_seen'] == 'today') {
                                        if ($user['profile'][$i]->last_seen != null) {
                                            $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->last_seen)));
                                            $date2 = new DateTime(date('Y/m/d H:i:s'));
                                            if ($date1->diff($date2)->days == 0) {
                                                $cleanResult[] = $user['profile'][$i];
                                            }
                                        }

                                    } else if ($input['last_seen'] == 'week') {
                                        if ($user['profile'][$i]->last_seen != null) {
                                            $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->last_seen)));
                                            $date2 = new DateTime(date('Y/m/d H:i:s'));
                                            if ($date1->diff($date2)->days <= 7) {
                                                $cleanResult[] = $user['profile'][$i];
                                            }
                                        }
                                    } else if ($input['last_seen'] == 'month') {
                                        if ($user['profile'][$i]->last_seen != null) {
                                            $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->last_seen)));
                                            $date2 = new DateTime(date('Y/m/d H:i:s'));
                                            if ($date1->diff($date2)->days <= 30) {
                                                $cleanResult[] = $user['profile'][$i];
                                            }
                                        }
                                    } else if ($input['last_seen'] == 'three_month') {
                                        if ($user['profile'][$i]->last_seen != null) {
                                            $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->last_seen)));
                                            $date2 = new DateTime(date('Y/m/d H:i:s'));
                                            if ($date1->diff($date2)->days <= 90) {
                                                $cleanResult[] = $user['profile'][$i];
                                            }
                                        }
                                    } else if ($input['last_seen'] == 'year') {
                                        if ($user['profile'][$i]->last_seen != null) {
                                            $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->last_seen)));
                                            $date2 = new DateTime(date('Y/m/d H:i:s'));
                                            if ($date1->diff($date2)->days <= 365) {
                                                $cleanResult[] = $user['profile'][$i];
                                            }
                                        }
                                    }

                                } else if (!empty($input['reg_date'])) {
                                    if ($input['reg_date'] == 'today') {
                                        if ($user['profile'][$i]->created_at != null) {
                                            $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->created_at)));
                                            $date2 = new DateTime(date('Y/m/d H:i:s'));
                                            if ($date1->diff($date2)->days == 0) {
                                                $cleanResult[] = $user['profile'][$i];
                                            }
                                        }

                                    } else if ($input['reg_date'] == 'week') {
                                        if ($user['profile'][$i]->created_at != null) {
                                            $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->created_at)));
                                            $date2 = new DateTime(date('Y/m/d H:i:s'));
                                            if ($date1->diff($date2)->days <= 7) {
                                                $cleanResult[] = $user['profile'][$i];
                                            }
                                        }
                                    } else if ($input['reg_date'] == 'month') {
                                        if ($user['profile'][$i]->created_at != null) {
                                            $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->created_at)));
                                            $date2 = new DateTime(date('Y/m/d H:i:s'));
                                            if ($date1->diff($date2)->days <= 30) {
                                                $cleanResult[] = $user['profile'][$i];
                                            }
                                        }
                                    } else if ($input['reg_date'] == 'three_month') {
                                        if ($user['profile'][$i]->created_at != null) {
                                            $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->created_at)));
                                            $date2 = new DateTime(date('Y/m/d H:i:s'));
                                            if ($date1->diff($date2)->days <= 90) {
                                                $cleanResult[] = $user['profile'][$i];
                                            }
                                        }
                                    } else if ($input['reg_date'] == 'year') {
                                        if ($user['profile'][$i]->created_at != null) {
                                            $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->created_at)));
                                            $date2 = new DateTime(date('Y/m/d H:i:s'));
                                            if ($date1->diff($date2)->days <= 365) {
                                                $cleanResult[] = $user['profile'][$i];
                                            }
                                        }
                                    }
                                } else {
                                    $cleanResult[] = $user['profile'][$i];
                                }
                            }
                        }
                    } else {
                        if (!empty($input['currently']) && @$input['currently'] == true) {


                            if ($user['profile'][$i]->last_seen != null) {
                                $date1 = new DateTime(date('Y-m-d H:i:s', strtotime($user['profile'][$i]->last_seen)));
                                $date2 = new DateTime(date('Y-m-d H:i:s'));
                                $interval = $date1->diff($date2);
                                $hours = ($interval->days * 24) + $interval->h
                                + ($interval->i / 60) + ($interval->s / 3600);

                                if ($hours < 24) {
                                    $cleanResult[] = $user['profile'][$i];
                                }

                            }
                        } else if (!empty($input['last_seen'])) {
                            if ($input['last_seen'] == 'today') {
                                if ($user['profile'][$i]->last_seen != null) {
                                    $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->last_seen)));
                                    $date2 = new DateTime(date('Y/m/d H:i:s'));
                                    if ($date1->diff($date2)->days == 0) {
                                        $cleanResult[] = $user['profile'][$i];
                                    }
                                }

                            } else if ($input['last_seen'] == 'week') {
                                if ($user['profile'][$i]->last_seen != null) {
                                    $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->last_seen)));
                                    $date2 = new DateTime(date('Y/m/d H:i:s'));
                                    if ($date1->diff($date2)->days <= 7) {
                                        $cleanResult[] = $user['profile'][$i];
                                    }
                                }
                            } else if ($input['last_seen'] == 'month') {
                                if ($user['profile'][$i]->last_seen != null) {
                                    $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->last_seen)));
                                    $date2 = new DateTime(date('Y/m/d H:i:s'));
                                    if ($date1->diff($date2)->days <= 30) {
                                        $cleanResult[] = $user['profile'][$i];
                                    }
                                }
                            } else if ($input['last_seen'] == 'three_month') {
                                if ($user['profile'][$i]->last_seen != null) {
                                    $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->last_seen)));
                                    $date2 = new DateTime(date('Y/m/d H:i:s'));
                                    if ($date1->diff($date2)->days <= 90) {
                                        $cleanResult[] = $user['profile'][$i];
                                    }
                                }
                            } else if ($input['last_seen'] == 'year') {
                                if ($user['profile'][$i]->last_seen != null) {
                                    $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->last_seen)));
                                    $date2 = new DateTime(date('Y/m/d H:i:s'));
                                    if ($date1->diff($date2)->days <= 365) {
                                        $cleanResult[] = $user['profile'][$i];
                                    }
                                }
                            }

                        } else if (!empty($input['reg_date'])) {
                            if ($input['reg_date'] == 'today') {
                                if ($user['profile'][$i]->created_at != null) {
                                    $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->created_at)));
                                    $date2 = new DateTime(date('Y/m/d H:i:s'));
                                    if ($date1->diff($date2)->days == 0) {
                                        $cleanResult[] = $user['profile'][$i];
                                    }
                                }

                            } else if ($input['reg_date'] == 'week') {
                                if ($user['profile'][$i]->created_at != null) {
                                    $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->created_at)));
                                    $date2 = new DateTime(date('Y/m/d H:i:s'));
                                    if ($date1->diff($date2)->days <= 7) {
                                        $cleanResult[] = $user['profile'][$i];
                                    }
                                }
                            } else if ($input['reg_date'] == 'month') {
                                if ($user['profile'][$i]->created_at != null) {
                                    $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->created_at)));
                                    $date2 = new DateTime(date('Y/m/d H:i:s'));
                                    if ($date1->diff($date2)->days <= 30) {
                                        $cleanResult[] = $user['profile'][$i];
                                    }
                                }
                            } else if ($input['reg_date'] == 'three_month') {
                                if ($user['profile'][$i]->created_at != null) {
                                    $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->created_at)));
                                    $date2 = new DateTime(date('Y/m/d H:i:s'));
                                    if ($date1->diff($date2)->days <= 90) {
                                        $cleanResult[] = $user['profile'][$i];
                                    }
                                }
                            } else if ($input['reg_date'] == 'year') {
                                if ($user['profile'][$i]->created_at != null) {
                                    $date1 = new DateTime(date('Y-m-d', strtotime($user['profile'][$i]->created_at)));
                                    $date2 = new DateTime(date('Y/m/d H:i:s'));
                                    if ($date1->diff($date2)->days <= 365) {
                                        $cleanResult[] = $user['profile'][$i];
                                    }
                                }
                            }
                        } else {
                            $cleanResult[] = $user['profile'][$i];
                        }
                    }

                }
            }


            $users = array();
            for ($i = 0; $i < sizeof($cleanResult); $i++) {
                $users[$i]['profile'] = DB::table('application_users')
                ->where('application_users.status', '<>', 'banded')
                ->where(['application_users.deleted_at' => null, 'application_users.id' => $cleanResult[$i]->id])
                ->join('countries', 'application_users.country_code', '=', 'countries.code')
                ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
                ->select('application_users.*', 'countries.ar_name as country_name', 'registration_aims.value as registration_aim')
                ->get();
                $users[$i]['application_user_images'] = DB::table('application_user_images')
                ->where(['deleted_at' => null, 'application_user_id' => $cleanResult[$i]->id])
                ->get();


            }

            if (sizeof($users) > 0) {
                for ($i = 0; $i < sizeof($users); $i++) {

                        /**********************************
                         * change image url
                         **********************************/

                        if (!isset($input['image'])) {
                            $users[$i]['profile'][0]->image = "http://awa.m-apps.co/" . $users[$i]['profile'][0]->image;
                        } else if ($input['image'] == false) {
                            if ($users[$i]['profile'][0]->gender == 'male') {
                                $users[$i]['profile'][0]->image = "http://awa.m-apps.co/" . 'uploads/avatar/male_avatar.png';
                            } else {
                                $users[$i]['profile'][0]->image = "http://awa.m-apps.co/" . 'uploads/avatar/female_avatar.png';
                            }
                        } else {

                            $users[$i]['profile'][0]->image = "http://awa.m-apps.co/" . $users[$i]['profile'][0]->image;
                        }

                        foreach ($users[$i]['application_user_images'] as $userImage) {
                            $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
                        }


                        if ($users[$i]['profile'][0]->nationality_code != null) {
                            $users[$i]['profile'][0]->nationality_name = DB::table('nationalities')
                            ->where(['deleted_at' => null, 'code' => $users[$i]['profile'][0]->nationality_code])
                            ->select('nationalities.ar_name as nationality_name')
                            ->first()->nationality_name;
                        } else {
                            $users[$i]['profile'][0]->nationality_name = null;
                        }

                        if ($users[$i]['profile'][0]->age_id != null) {
                            $users[$i]['profile'][0]->age = DB::table('ages')
                            ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->age_id])
                            ->select('ages.value as age')
                            ->first()->age;
                        } else {
                            $users[$i]['profile'][0]->age = null;
                        }

                        if ($users[$i]['profile'][0]->educational_qualification_id != null) {
                            $users[$i]['profile'][0]->educational_qualification = DB::table('educational_qualifications')
                            ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->educational_qualification_id])
                            ->select('educational_qualifications.value as educational_qualification')
                            ->first()->educational_qualification;
                        } else {
                            $users[$i]['profile'][0]->educational_qualification = null;
                        }

                        if ($users[$i]['profile'][0]->eye_color_id != null) {
                            $users[$i]['profile'][0]->eye_color = DB::table('eye_colors')
                            ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->eye_color_id])
                            ->select('eye_colors.value as eye_color')
                            ->first()->eye_color;
                        } else {
                            $users[$i]['profile'][0]->eye_color = null;
                        }

                        if ($users[$i]['profile'][0]->skin_color_id != null) {
                            $users[$i]['profile'][0]->skin_color = DB::table('skin_colors')
                            ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->skin_color_id])
                            ->select('skin_colors.value as skin_color')
                            ->first()->skin_color;
                        } else {
                            $users[$i]['profile'][0]->skin_color = null;
                        }

                        if ($users[$i]['profile'][0]->hair_color_id != null) {
                            $users[$i]['profile'][0]->hair_color = DB::table('hair_colors')
                            ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->hair_color_id])
                            ->select('hair_colors.value as hair_color')
                            ->first()->hair_color;
                        } else {
                            $users[$i]['profile'][0]->hair_color = null;
                        }


                        if ($users[$i]['profile'][0]->social_status_id != null) {
                            $users[$i]['profile'][0]->social_status = DB::table('social_statuses')
                            ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->social_status_id])
                            ->select('social_statuses.value as social_status')
                            ->first()->social_status;
                        } else {
                            $users[$i]['profile'][0]->social_status = null;
                        }

                        if ($users[$i]['profile'][0]->occupation_id != null) {
                            $users[$i]['profile'][0]->occupation = DB::table('occupations')
                            ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->occupation_id])
                            ->select('occupations.value as occupation')
                            ->first()->occupation;
                        } else {
                            $users[$i]['profile'][0]->occupation = null;
                        }

                        if ($users[$i]['profile'][0]->length_category_id != null) {
                            $users[$i]['profile'][0]->length_category = DB::table('length_categories')
                            ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->length_category_id])
                            ->select('length_categories.value as length_category')
                            ->first()->length_category;
                        } else {
                            $users[$i]['profile'][0]->length_category = null;
                        }

                        if ($users[$i]['profile'][0]->weight_category_id != null) {
                            $users[$i]['profile'][0]->weight_category = DB::table('weight_categories')
                            ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->weight_category_id])
                            ->select('weight_categories.value as weight_category')
                            ->first()->weight_category;
                        } else {
                            $users[$i]['profile'][0]->weight_category = null;
                        }

                        if ($users[$i]['profile'][0]->gender == 'male') {
                            $users[$i]['profile'][0]->gender_title = "ذكر";
                        } else {
                            $users[$i]['profile'][0]->gender_title = "أنثى";
                        }
                    }
                }




                $data = $users;

            }

            return response(array("status" => $success, "message" => $message, "data" => $data), \Illuminate\Http\Response::HTTP_OK);

        });
Route::post('normal', function (Request $request) {
    $success = false;
    $data = null;
    $message = "تم ارجاع النتائج بنجاح";
    $input = $request->all();

    $validator = Validator::make($request->all(), [
        'user_id' => ['required', Rule::exists('application_users', 'id')],
        'gender' => ['required',
        Rule::in(['male', 'female']),
    ],
    'registration_aim_id' => ['nullable', 'exists:registration_aims,id'],
    'age_id' => ['nullable', 'exists:ages,id'],
    'educational_qualification_id' => ['nullable', 'exists:educational_qualifications,id'],
    'country_code' => ['nullable', 'exists:countries,code']
]
, [
    'gender.required' => 'حقل الجنس حقل مطلوب',
    'user_id.required' => 'حقل رقم المستخدم حقل مطلوب',
    'user_id.exists' => 'حقل رقم المستخدم المدخل غير موجود',
    'gender.in' => 'لقد اخترت جنس خاطئ',
    'registration_aim_id.exists' => 'الرجاء اختيار هدف من القائمة',
    'age_id.exists' => 'الرجاء اختيار عمر من القائمة',
    'educational_qualification_id.exists' => 'الرجاء اختيار مؤهل علمي من القائمة',
    'country_code.exists' => 'الرجاء اختيار دولة من القائمة'

]);

    if ($validator->fails()) {
        $message = $validator->errors()->first();
    }else{
        $success = true;
        $blocks = DB::table('user_application_blocks')
        ->where(['user_application_blocks.deleted_at' => null, 'user_application_blocks.from_user_id' => $input['user_id']])
        ->join('application_users', 'user_application_blocks.user_id', '=', 'application_users.id')
        ->select('user_application_blocks.user_id')->get();
        $query = "SELECT * FROM application_users WHERE deleted_at IS NULL 
        AND id <> '".$input['user_id']."'";
        if(isset($input['gender']) && !empty($input['gender'])){
            $query = $query . " AND gender = '".$input['gender']."'";
        }
        if(isset($input['registration_aim_id']) && !empty($input['registration_aim_id'])){
            $query = $query . " AND registration_aim_id = '".$input['registration_aim_id']."'";
        }

        if(isset($input['educational_qualification_id']) && !empty($input['educational_qualification_id'])){
            $query = $query . " AND educational_qualification_id = '".$input['educational_qualification_id']."'";
        }

        if(isset($input['age_id']) && !empty($input['age_id'])){
            $query = $query . " AND age_id = '".$input['age_id']."'";
        }

        if(isset($input['country_code']) && !empty($input['country_code'])){
            $query = $query . " AND country_code = '".$input['country_code']."'";
        }

        $user['profile'] = DB::select($query);

        $cleanResult = array();
        for ($i = 0; $i < sizeof($user['profile']); $i++) {
            if (!array_key_exists($user['profile'][$i]->id, $cleanResult) && $user['profile'][$i]->deleted_at == null &&
                $user['profile'][$i]->status != 'banded') {
                if (sizeof($blocks) > 0) {
                    foreach ($blocks as $block) {
                        if ($block->user_id != $user['profile'][$i]->id) {
                            $cleanResult[] = $user['profile'][$i];
                        }
                    }
                } else {
                    $cleanResult[] = $user['profile'][$i];
                }


            }
        }
        
        $users = array();
        for ($i = 0; $i < sizeof($cleanResult); $i++) {
            $users[$i]['profile'] = DB::table('application_users')
            ->where('application_users.status', '<>', 'banded')
            ->where(['application_users.deleted_at' => null, 'application_users.id' => $cleanResult[$i]->id])
            ->join('countries', 'application_users.country_code', '=', 'countries.code')
            ->join('registration_aims', 'application_users.registration_aim_id', '=', 'registration_aims.id')
            ->select('application_users.*', 'countries.ar_name as country_name', 'registration_aims.value as registration_aim')
            ->get();
            
            $users[$i]['application_user_images'] = DB::table('application_user_images')
            ->where(['deleted_at' => null, 'application_user_id' => $cleanResult[$i]->id])
            ->get();
            
        }

        

        if (sizeof($users) > 0) {
            for ($i = 0; $i < sizeof($users); $i++) {

                /**********************************
                * change image url
                **********************************/

                if (!isset($input['image'])) {
                    $users[$i]['profile'][0]->image = "http://awa.m-apps.co/" . $users[$i]['profile'][0]->image;

                } else if ($input['image'] == false) {

                    if ($users[$i]['profile'][0]->gender == 'male') {
                        $users[$i]['profile'][0]->image = "http://awa.m-apps.co/" . 'uploads/avatar/male_avatar.png';
                    } else {
                        $users[$i]['profile'][0]->image = "http://awa.m-apps.co/" . 'uploads/avatar/female_avatar.png';
                    }
                } else {

                    $users[$i]['profile'][0]->image = "http://awa.m-apps.co/" . $users[$i]['profile'][0]->image;
                    
                }

                foreach ($users[$i]['application_user_images'] as $userImage) {
                    $userImage->image = "http://awa.m-apps.co/" . $userImage->image;
                }
                
                if ($users[$i]['profile'][0]->nationality_code != null) {
                    $users[$i]['profile'][0]->nationality_name = DB::table('nationalities')
                    ->where(['deleted_at' => null, 'code' => $users[$i]['profile'][0]->nationality_code])
                    ->select('nationalities.ar_name as nationality_name')
                    ->first()->nationality_name;
                } else {
                    $users[$i]['profile'][0]->nationality_name = null;
                }

                if ($users[$i]['profile'][0]->age_id != null) {
                    $users[$i]['profile'][0]->age = DB::table('ages')
                    ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->age_id])
                    ->select('ages.value as age')
                    ->first()->age;
                } else {
                    $users[$i]['profile'][0]->age = null;
                }

                if ($users[$i]['profile'][0]->educational_qualification_id != null) {
                    $users[$i]['profile'][0]->educational_qualification = DB::table('educational_qualifications')
                    ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->educational_qualification_id])
                    ->select('educational_qualifications.value as educational_qualification')
                    ->first()->educational_qualification;
                } else {
                    $users[$i]['profile'][0]->educational_qualification = null;
                }

                if ($users[$i]['profile'][0]->eye_color_id != null) {
                    $users[$i]['profile'][0]->eye_color = DB::table('eye_colors')
                    ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->eye_color_id])
                    ->select('eye_colors.value as eye_color')
                    ->first()->eye_color;
                } else {
                    $users[$i]['profile'][0]->eye_color = null;
                }

                if ($users[$i]['profile'][0]->skin_color_id != null) {
                    $users[$i]['profile'][0]->skin_color = DB::table('skin_colors')
                    ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->skin_color_id])
                    ->select('skin_colors.value as skin_color')
                    ->first()->skin_color;
                } else {
                    $users[$i]['profile'][0]->skin_color = null;
                }

                if ($users[$i]['profile'][0]->hair_color_id != null) {
                    $users[$i]['profile'][0]->hair_color = DB::table('hair_colors')
                    ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->hair_color_id])
                    ->select('hair_colors.value as hair_color')
                    ->first()->hair_color;
                } else {
                    $users[$i]['profile'][0]->hair_color = null;
                }


                if ($users[$i]['profile'][0]->social_status_id != null) {
                    $users[$i]['profile'][0]->social_status = DB::table('social_statuses')
                    ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->social_status_id])
                    ->select('social_statuses.value as social_status')
                    ->first()->social_status;
                } else {
                    $users[$i]['profile'][0]->social_status = null;
                }

                if ($users[$i]['profile'][0]->occupation_id != null) {
                    $users[$i]['profile'][0]->occupation = DB::table('occupations')
                    ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->occupation_id])
                    ->select('occupations.value as occupation')
                    ->first()->occupation;
                } else {
                    $users[$i]['profile'][0]->occupation = null;
                }

                if ($users[$i]['profile'][0]->length_category_id != null) {
                    $users[$i]['profile'][0]->length_category = DB::table('length_categories')
                    ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->length_category_id])
                    ->select('length_categories.value as length_category')
                    ->first()->length_category;
                } else {
                    $users[$i]['profile'][0]->length_category = null;
                }

                if ($users[$i]['profile'][0]->weight_category_id != null) {
                    $users[$i]['profile'][0]->weight_category = DB::table('weight_categories')
                    ->where(['deleted_at' => null, 'id' => $users[$i]['profile'][0]->weight_category_id])
                    ->select('weight_categories.value as weight_category')
                    ->first()->weight_category;
                } else {
                    $users[$i]['profile'][0]->weight_category = null;
                }


                if ($users[$i]['profile'][0]->gender == 'male') {
                    $users[$i]['profile'][0]->gender_title = "ذكر";
                } else {
                    $users[$i]['profile'][0]->gender_title = "أنثى";
                }
                
            }

        }



        $data = $users;

    }

    return response(array("status" => $success, "message" => $message, "data" => $data), \Illuminate\Http\Response::HTTP_OK);

});

});
