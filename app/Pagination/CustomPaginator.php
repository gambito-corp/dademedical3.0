<?php

namespace App\Pagination;

use Illuminate\Pagination\LengthAwarePaginator as BasePaginator;

class CustomPaginator extends BasePaginator
{
    /**
     * Render the paginator using the given view.
     *
     * @param string|null $view
     * @param array $data
     * @return \Illuminate\Contracts\Support\Htmlable
     */
    public function customRender($view = null, $data = [])
    {
        return $this->render($view ?: 'components.custom-pagination', $data);
    }
}
