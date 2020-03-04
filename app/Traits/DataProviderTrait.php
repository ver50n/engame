<?php

namespace App\Traits;

trait DataProviderTrait
{
    public function published()
    {
        return $this->where('is_active', 1)
            ->where('is_published', 1);
    }
    
    public function filterId($dp, $filters)
    {
        if(isset($filters['id']) && $filters['id'] != "")
            $dp = $dp->where($this->table.'.id', $filters['id']);
        return $dp;
    }

    public function filterIsActive($dp, $filters)
    {
        if(isset($filters['is_active']) && $filters['is_active'] != "")
            $dp = $dp->where($this->table.'.is_active', $filters['is_active']);
        return $dp;
    }

    public function filterIsPublished($dp, $filters)
    {
        if(isset($filters['is_published']) && $filters['is_published'] != "")
            $dp = $dp->where($this->table.'.is_published', $filters['is_published']);
        return $dp;
    }

    public function filterCreatedAt($dp, $filters)
    {
        if((!empty($filters['created_at_start']) && $filters['created_at_start'] !== '')
            || (!empty($filters['created_at_end']) && $filters['created_at_end'] !== '')) {
            if((!empty($filters['created_at_start']) && $filters['created_at_start'] !== '')
                && (!empty($filters['created_at_end']) && $filters['created_at_end'] !== '')) {
                $dp = $dp->whereBetween($this->table.'.created_at', [$filters['created_at_start'], $filters['created_at_end']]);
            } else if ((!empty($filters['created_at_start']) && $filters['created_at_start'] !== '')
                && (empty($filters['created_at_end']) && $filters['created_at_end'] == '')) {
                $dp = $this->where($this->table.'.created_at', '>=', $filters['created_at_start']);
            } else if ((empty($filters['created_at_start']) && $filters['created_at_start'] == '')
                && (!empty($filters['created_at_end']) && $filters['created_at_end'] !== '')) {
                $dp = $dp->where($this->table.'.created_at', '<=', $filters['created_at_end']);
            }
        }
        return $dp;
    }

    public function filterUpdatedAt($dp, $filters)
    {
        if((!empty($filters['updated_at_start']) && $filters['updated_at_start'] !== '')
            || (!empty($filters['updated_at_end']) && $filters['updated_at_end'] !== '')) {
            if((!empty($filters['updated_at_start']) && $filters['updated_at_start'] !== '')
                && (!empty($filters['updated_at_end']) && $filters['updated_at_end'] !== '')) {
                $dp = $dp->whereBetween($this->table.'.updated_at', [$filters['updated_at_start'], $filters['updated_at_end']]);
            } else if ((!empty($filters['updated_at_start']) && $filters['updated_at_start'] !== '')
                && (empty($filters['updated_at_end']) && $filters['updated_at_end'] == '')) {
                $dp = $dp->where($this->table.'.updated_at', '>=', $filters['updated_at_start']);
            } else if ((empty($filters['updated_at_start']) && $filters['updated_at_start'] == '')
                && (!empty($filters['updated_at_end']) && $filters['updated_at_end'] !== '')) {
                $dp = $dp->where($this->table.'.updated_at', '<=', $filters['updated_at_end']);
            }
        }
        return $dp;
    }

    public function sortBy($dp, $options)
    {
        if(!$this->created_at)
            return $dp;
            
        return $dp->orderBy('created_at', 'desc');
    }

    public function retrieve($dp, $options)
    {
        if(isset($options['pagination']) && $options['pagination']) {
            $rowPerPage = \Session::get('rowPerPage') ? \Session::get('rowPerPage') : 12;
            $page = isset($options['page']) ? $options['page'] : 1;
            
            $dp = $dp->Paginate($rowPerPage, ['*'], 'page', $page);
        }

        return $dp;
    }

    public function getLanguageProperty($relation, $key)
    {
        $language = $this->$relation;
        $result = \Lang::get('common.info.not-set');

        if($language && $language->$key)
            $result = $language->$key;

        return $result;
    }
}