<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule; //for in: validation
use App\models\wpBlogImages\Wpress_images_Category; //model for DB table {wpressimage_category} for Range in: validation

class UpdateExistingArticleRequest extends FormRequest
{
    public $validator = null;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return false; //return False will stop everything
		return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //getting all existing categories from DB {wpressimage_category}, get from DB only column "id". Used for validation in range {Rule::in(['admin', 'owner']) ]}, ['13', '17']
		$existingRoles = Wpress_images_Category::select('wpCategory_id')->get(); 
		$rolesList  = array(); // array to contain all roles id  from DB in format ['13', '17']
		foreach($existingRoles as $n){
			array_push($rolesList, $n->wpCategory_id);	
		}
		
        
        return [
		    'title'        => 'required|string|min:3|max:255',
		    'body'         => 'required|string|min:5|max:255', 
            'selectV'      => ['required', 'string', Rule::in($rolesList) ],  //integer];        
			//image validation https://hdtuto.com/article/laravel-57-image-upload-with-validation-example
            //Image is not required for update
			//'imagesZZZ'    => ['required', /*'image',*/ /*'mimes:jpeg,png,jpg,gif,svg',*/ 'max:2048' ], // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',,
			//'filename' => 'required',
		    'imagesZZZ'    => 'array',                                      //validation for array of images //Amendments 2022 (+2 next lines), in CLEANSED version 'imagesZZZ' changed to 'imagesSet'
			'imagesZZZ.*'  => 'image|mimes:jpg,jpeg,gif,svg,png|max:2048',  //validation for array of images
		];
    }
    
    
    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
		
		
        // use trans instead on Lang 
        return [
           //'username.required'  => Lang::get('userpasschange.usernamerequired'),
		   'title.required'       => 'Kindly asking for a title',
	       'body.required'        => 'We need u to specify the article text',
		   'body.min'             => 'We kindly require more than 5 letters for article text',
           'selectV.required'     => 'We need u to specify the category',
           'selectV.in'           => 'You enetered invalid category',
		   //'imagesZZZ.required'   => 'Image is very much required',
		   //'imagesZZZ.image'    => 'Make sure it is an image',
		   //'imagesZZZ.mimes'    => 'Must be .jpeg, .png, .jpg, .gif, .svg file. Max size is 2048',
		   //'imagesZZZ.max'      => 'Sorry! Maximum allowed size for an image is 2MB',
		   //'imagesZZZ.min'      => 'Your image is too small',
		   'imagesZZZ.*.image'    => 'Make sure you have uploaded an image',  //Amendments 2022 (+2 next lines), in CLEANSED version 'imagesZZZ' changed to 'imagesSet'
		   'imagesZZZ.*.mimes'    => 'Must be .jpeg, .png, .jpg, .gif, .svg file. Max size is 2048',
		   'imagesZZZ.*.max'      => 'Sorry! Maximum allowed size for an image is 2MB',
		];
	}
	

  
		   
		   
	 
	/**
     * To override Return validation errors. In this case it will return and exucute code in Controller, even if Request Validation fails
     * @param Validator $validator
     * 
     */
    
    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        //return response()->json(['error' => true, 'errors' => $validator->errors()->all()]);
    }
    
    
    /**
     * Return validation errors 
     *
     * @param Validator $validator
     */
     
    /*public function withValidator(Validator $validator)
    {
	
	    if ($validator->fails()) {
            //return redirect('/createNewWpressImg')->withInput()->with('flashMessageFailX', 'Validation Failed!!!' )->withErrors($validator);
            return response()->json(['error' => true, 'errors' => $validator->errors()->all()]);
        }
	}*/
}
