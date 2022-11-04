<?php

namespace App\Http\Controllers;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProductOcCreateRequest;
use App\Http\Requests\ProductOcUpdateRequest;
use App\Repositories\ProductOcRepositoryEloquent;
use App\Validators\ProductOcValidator;

/**
 * Class ProductOcsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ProductOcsController extends Controller
{
    /**
     * @var ProductOcRepository
     */
    protected $repository;

    /**
     * @var ProductOcValidator
     */
    protected $validator;

    /**
     * ProductOcsController constructor.
     *
     * @param ProductOcRepository $repository
     * @param ProductOcValidator $validator
     */
    public function __construct(ProductOcRepositoryEloquent $repository, ProductOcValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }


    public function existsElement($element, $sku, $ocno){
        $exist = false;
        foreach($element as $key => $value){
            foreach($value["oc"] as $key2 => $value2 ){
                //for ($i = 0; $i < count($value); $i++) { 
                    if($value["sku"] == $sku && $value2["ocno"] == $ocno) {
                       $exist = true;
                    }
                //}
            }
        }

        return $exist;
    }

    /* Variable $mainElement como lo recibido en el request y Variable $secondaryElement
       como los registros en la base de datos... Compara que los objetos enviados en la request existan en la base de datos, 
       si no existen en la request hay que borrarlos, si existen en la request pero no en la base de datos hay que crearlos*/
    public function compareObjects($mainElement, $secondaryElement){
        
        $notInExistence = array();
        
        foreach ($secondaryElement as $key => $value) {

                if(!($this->existsElement($mainElement, $value["sku"], $value["ocno"]))){
                
                    array_push($notInExistence, array(
                        "sku" => $value["sku"],
                        "ocno" => $value["ocno"]
                    ));
    
                }
            
        }

        return $notInExistence;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {



        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $productOcs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $productOcs,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductOcCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */

    public function store(ProductOcCreateRequest $request)
    {
        try {
            
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $data = $request->data;

            $dataSaved = $this->repository->all();

            $valuesToDelete = $this->compareObjects($data, $dataSaved);

            $productOcArr = array();

            foreach($data as $key => $value){
                foreach($value["oc"] as $index => $oc){
                    
                    $productOc = $this->repository->updateOrCreate(
                    [
                        'sku' => $value['sku'],
                        'ocno' => $oc['ocno'], 
                    ],
                    [
                        'oc_date' => $oc['oc_date'],
                        'oc_date_required' => $oc['oc_date_required'],
                        'qty' => $oc['qty']
                    ]);

                    array_push($productOcArr, $productOc);
                }

            }

            foreach($valuesToDelete as $key2 => $value2){
                
                $this->repository->deleteWhere([
                    "sku" => $value2["sku"], "ocno" => $value2["ocno"]
                ]);
            }
            


            $response = [
                'success' => true,
                'data' => $productOcArr,
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }


        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success'   => false,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productOc = $this->repository->findWhereIn("sku", [$id]);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $productOc,
            ]);
        }

        return view('productOcs.show', compact('productOc'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productOc = $this->repository->find($id);

        return view('productOcs.edit', compact('productOc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductOcUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ProductOcUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $productOc = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ProductOc updated.',
                'data'    => $productOc->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'ProductOc deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ProductOc deleted.');
    }
}
