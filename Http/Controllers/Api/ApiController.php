<?php

namespace Modules\Block\Http\Controllers\Api;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Modules\Block\Entities\Block;


class ApiController extends Controller
{

    public function __construct()
    {}


    /**
     * Obtener los datos para la tabla de la pagina index
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JSON
     */
    public function index(Request $request)
    {
        $columns = [
            'id',
            'name',
            'created_at',
            'actions',
        ];

        $limit = $request->get('length');
        $start = $request->get('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search_value = $request->input('search.value');

        $data = [];

        $totalData = Block::count();

        if($search_value != '')
        {
            $block = Block::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->where('name', 'like', '%'.$search_value.'%')
                ->get();

            $totalFiltered = count($block);
        } 
        else 
        {
            $block = Block::offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

            $totalFiltered = count($block);
        }

        

        if(!empty($block))
        {
            foreach ($block as $block) 
            {
                $edit = locale().'/backend/block/blocks/'.$block->id.'/edit';
                $delete = locale().'/backend/block/blocks/'.$block->id;
                
                $nestedData['id'] = $block->id;
                $nestedData['name'] = $block->name;
                $nestedData['created_at'] = $block->created_at;
                $nestedData['actions'] = "<div class='btn-group'>
                <a href='{$edit}' class='btn btn-default'><i class='fas fa-edit'></i></a>
                <button class='btn btn-danger' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='{$delete}'><i class='fas fa-trash-alt'></i></button></div>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        return Response::json($json_data);
    }
}
