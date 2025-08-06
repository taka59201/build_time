<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ItemController extends Controller
{
    public function index()
    {
        // ---- Query params ----
        $q        = request('q', '');
        $sort     = request('sort', 'id');     // id|name|price
        $dir      = request('dir', 'desc');    // asc|desc
        $perPage  = (int) request('per_page', 20); // 10|20|50|100 など
        $perPage  = in_array($perPage, [10,20,50,100], true) ? $perPage : 20;
        $page     = (int) request('page', 1);
        $priceMin = request()->filled('price_min') ? (int) request('price_min') : null;
        $priceMax = request()->filled('price_max') ? (int) request('price_max') : null;

        // ---- ダミーデータ（500件）----
        $all = Collection::times(500, function ($i) {
            return [
                'id'    => $i,
                'name'  => "Item #$i",
                'price' => mt_rand(100, 9999),
                'cat'   => ['A','B','C'][array_rand(['A','B','C'])],
            ];
        });

        // ---- 検索（名前に部分一致）----
        if ($q !== '') {
            $needle = Str::lower($q);
            $all = $all->filter(fn ($row) => Str::contains(Str::lower($row['name']), $needle));
        }

        // ---- 価格フィルタ ----
        if ($priceMin !== null) {
            $all = $all->where('price', '>=', $priceMin);
        }
        if ($priceMax !== null) {
            $all = $all->where('price', '<=', $priceMax);
        }

        // ---- ソート ----
        $all = $all->sortBy($sort, SORT_REGULAR, $dir === 'desc')->values();

        // ---- ページネーション ----
        $slice = $all->slice(($page - 1) * $perPage, $perPage)->values();
        $paginator = new LengthAwarePaginator(
            $slice,
            $all->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return Inertia::render('Items/Index', [
            'items' => [
                'data'         => $paginator->items(),
                'links'        => $paginator->linkCollection(),
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'total'        => $paginator->total(),
                'per_page'     => $paginator->perPage(),
            ],
            'filters' => [
                'q'         => $q,
                'sort'      => $sort,
                'dir'       => $dir,
                'per_page'  => $perPage,
                'price_min' => $priceMin,
                'price_max' => $priceMax,
            ],
            // 初期表示用の選択肢
            'options' => [
                'sorts' => [
                    ['value' => 'id',    'label' => 'ID'],
                    ['value' => 'name',  'label' => 'Name'],
                    ['value' => 'price', 'label' => 'Price'],
                ],
                'dirs' => [
                    ['value' => 'asc',  'label' => 'Asc'],
                    ['value' => 'desc', 'label' => 'Desc'],
                ],
                'perPages' => [10,20,50,100],
            ],
        ]);
    }
}
