<?php

namespace App\Http\Traits;

use Illuminate\Pagination\LengthAwarePaginator;

trait PaginationTrait {
    public function paginateRelation($relation, $perPage = 4, $currentPageName = 'page', $path = null) {
        $allItems = $relation->get();
        $currentPage = LengthAwarePaginator::resolveCurrentPage($currentPageName);
        $offset = ($currentPage - 1) * $perPage;
        $currentItems = $allItems->slice($offset, $perPage)->all();

        return new LengthAwarePaginator(
            $currentItems,
            $allItems->count(),
            $perPage,
            $currentPage,
            ['path' => $path ?: url()->current(), 'pageName' => $currentPageName]
        );
    }

    public function setPaginatedRelation($model, $relationName, $query, $perPage = 4, $currentPageName = 'page') {
        $paginatedData = $this->paginateRelation($query, $perPage, $currentPageName);
        $model->setRelation($relationName, $paginatedData);
    }
}
