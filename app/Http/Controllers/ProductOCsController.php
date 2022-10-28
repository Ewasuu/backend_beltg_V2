<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProductOCCreateRequest;
use App\Http\Requests\ProductOCUpdateRequest;
use App\Repositories\ProductOCRepository;
use App\Validators\ProductOCValidator;

/**
 * Class ProductOCsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ProductOCsController extends Controller
{
    /**
     * @var ProductOCRepository
     */
    protected $repository;

    /**
     * @var ProductOCValidator
     */
    protected $validator;

    /**
     * ProductOCsController constructor.
     *
     * @param ProductOCRepository $repository
     * @param ProductOCValidator $validator
     */
    public function __construct(ProductOCRepository $repository, ProductOCValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $productOCs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $productOCs,
            ]);
        }

        return view('productOCs.index', compact('productOCs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductOCCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ProductOCCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $productOC = $this->repository->create($request->all());

            $response = [
                'message' => 'ProductOC created.',
                'data'    => $productOC->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productOC = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $productOC,
            ]);
        }

        return view('productOCs.show', compact('productOC'));
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
        $productOC = $this->repository->find($id);

        return view('productOCs.edit', compact('productOC'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductOCUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ProductOCUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $productOC = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ProductOC updated.',
                'data'    => $productOC->toArray(),
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
                'message' => 'ProductOC deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ProductOC deleted.');
    }
}
