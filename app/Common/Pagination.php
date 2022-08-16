<?php

namespace App\Common;


class Pagination
{
    /**
     * maximum number of records per page
     *
     * @var integer
     */
    private int $limit;

    /**
     * number total of records
     *
     * @var integer
     */
    private int $total;

    /**
     * number total of pages
     *
     * @var integer
     */
    private int $pages;

    /**
     * current page
     *
     * @var integer
     */
    private int $current;


    /**
     * class constructor
     *
     * @param integer $total
     * @param integer $current
     * @param integer $limit
     */
    public function __construct(int $total, int $current=1, int $limit=10)
    {
        // set private properties
        $this->total=$total;
        $this->limit=$limit;
        $this->current= (is_numeric($current) and $current > 0) ? $current : 1;
        
        // calculate the pagination
        $this->calculate();
        
    }


    /**
     * Method responsible for calculate the pagination
     *
     */
    private function calculate(): void
    {
        //calculates the number of pages
        $this->pages = $this->total > 0 ? ceil($this->total / $this->limit) : 1;

        //checks if the current page is less than the total pages
        $this->current = $this->current <= $this->pages ? $this->current : $this->pages;
        
    }

    /**
     * Method responsible for generate the limit condition in SQL format
     *
     * @return string
     */
    public function getLimit(): string
    {
        // get the offset for the query SQL
        $offset = ($this->current - 1) * $this->limit;

        // returns a string in the format: 'offset,limit'
        return $offset . ',' . $this->limit;
    }

    /**
     * Method responsible for returning a list of available pages
     *
     * @return array [["page" => int, "current" => bol],...]
     */
    public function getPages(): array
    {
        //if there is only one page return an empty array
        if ($this->pages == 1) return [];

        //return an array in the format: ["page" => int, "current" => bol]
        return array_map(function($page){
            return [
                "page" => $page,
                "current" => $page == $this->current
            ];
        }, range(1, $this->pages));

    }
}

