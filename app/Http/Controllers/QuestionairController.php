<?php

namespace App\Http\Controllers;

use App\Http\Models\Type;
use App\Http\Models\Asnwers;
use Illuminate\Http\Request;
use App\Http\Models\Questions;
use App\Http\Models\Questionair;



class QuestionairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            
            $questionairObj  = Questionair::all();
            return view('questionair/listing', compact('questionairObj'));

        }catch(Exception $exp){
            self::logError($exp, __CLASS__, __METHOD__);
            return \Redirect::back()->with(['serverError' => trans('messages.error.server_error')]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questionair/create');
    }

    /**
     * Store Questionair in database .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{
 

            $questionairObj  = new Questionair();

            $filteredData  = $request->only('name','time','duration','canResume');

            $filteredData['user_id'] = \Auth::user()->id;

            $questionairObj->fill($filteredData)->save();

            $type  = $request->get('type');
            
            $question  = $request->get('question');
            
            $answer  = $request->get('answer');
            
            $choice  = $request->get('choice');

            $correct = $request->get('correct');

            for($i = 0; $i < count($type) ; $i++){
               
                $typeObj  = new Type();
                $type  = array_get($type , $i);
                if($type != ''){
                    $typeObj->fill([
                                'questionair_id' => $questionairObj->id,
                                'question_type' => $type
                                ])->save();
                }

                $questionObj  = new Questions();

                if(array_get($question,$i) != ''){
                    $questionObj->fill([
                                    'type_id' => $typeObj->id,
                                    'question' => array_get($question,$i)
                                    ])->save();                    
                }

                $qid = $questionObj->id;
                if($type == 'text'){

                    $answerObj  = new Asnwers();
                    $answerObj->fill([
                                    'questions_id' => $questionObj->id, 
                                    'answer'=> array_get($answer,$i),
                                ])->save();  
                }else{
                    for($j = 0 ; $j < count($choice) ; $j++){
                        $answerObj  = new Asnwers();
                        $answerObj->fill([
                                        'question_id' => $questionObj->id, 
                                        'answer'=> array_get($choice,$i),
                                        'correct' => array_get($correct,$i) != '' ?  1 : 0
                                    ])->save();  
                    }
                }

            } 

            return \Redirect(url('questionair'))->with(['success' => trans('messages.success.questionair_created')]);            

        }catch(\Exception $exp){
            self::logError($exp, __CLASS__, __METHOD__);
            return \Redirect::back()->withInput($request->all())->with(['serverError' => trans('messages.error.server_error')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            $questionairObj  = Questionair::where('id',$id)->first();

            if($questionairObj instanceOf Questionair){
                $questionairObj->delete();                
                return response()->json([
                                'code'=> 1 , 
                                'message'=> trans('messages.success.questionair_deleted')
                                ]);
            }else{
                return response()->json([
                                'code'=> 0 , 
                                'message'=> trans('messages.error.invalid_identifier')
                                ]);
            }

        }catch(\Exception $exp){
            self::logError($exp, __CLASS__, __METHOD__);
            return response()->json(['code'=> 0, 'message'=> trans('messages.error.server_error')]);
        }
    }
}
