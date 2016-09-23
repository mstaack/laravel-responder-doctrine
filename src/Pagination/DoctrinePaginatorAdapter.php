<?php

namespace Flugg\Responder\Pagination;

use League\Fractal\Pagination\PaginatorInterface;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

class DoctrinePaginatorAdapter implements PaginatorInterface
{

    protected $paginator;

    public function __construct(DoctrinePaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Get the current page.
     *
     * @return int
     */
    public function getCurrentPage()
    {
        $offset = $this->paginator->getQuery()->getFirstResult();
        $limit = $this->paginator->getQuery()->getMaxResults();
        return ceil($offset / $limit);
    }

    /**
     * Get the last page.
     *
     * @return int
     */
    public function getLastPage()
    {
        $total = $this->getCount();
        $limit = $this->paginator->getQuery()->getMaxResults();
        return ceil($total / $limit);
    }

    /**
     * Get the total.
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->paginator->count();
    }

    /**
     * Get the count.
     *
     * @return int
     */
    public function getCount()
    {
        return $this->paginator->getIterator()->count();
    }

    /**
     * Get the number per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return $this->paginator->getQuery()->getMaxResults();
    }

    /**
     * Get the url for the given page.
     *
     * @param int $page
     *
     * @return string
     */
    public function getUrl($page)
    {
        // @TODO
        return $page;
        // return $this->paginator->url($page);
    }

    public function getPaginator()
    {
        return $this->paginator;
    }
}
