<?php

namespace App\Models;

use App\Common\Database;
use \PDO;

class Vaga
{
	
    /**
     * unique identifier
     * 
     * @var Integer
     */
    public $id;

    /**
     * job title
     *
     * @var String
     */
    public $titulo;

    /**
     * job description - may contain html code
     *
     * @var String
     */
    public $descricao;

    /**
     * job status
     *
     * @var string(s/n)
     */
    public $ativo;

    /**
     * job date
     *
     * @var String(Datastamp)
     */
    public $data;

    /**
     * Method responsible for add job into database
     *
     * @param string $titulo
     * @param string $descricao
     * @param string $ativo
     * @return boolean
     */

    public function add($titulo, $descricao, $ativo)
    {
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->ativo = $ativo;

        //define date
        $this->data = date('Y-m-d H:i:s');

        //insert job in database
        $obDatabase = new Database('vagas');
        $this->id = $obDatabase->insert([
                                            'titulo' => $this->titulo,
                                            'descricao' => $this->descricao,
                                            'ativo' => $this->ativo,
                                            'data' => $this->data
                                        ]);
       

        //return success
        return true;
    }


    /**
     * Method responsible for update job in the database
     *
     * @param string $titulo
     * @param string $descricao
     * @param string $ativo
     * @return boolean
     */
    public function update($titulo, $descricao, $ativo)
    {
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->ativo = $ativo;

        return (new Database('vagas'))->update('id = '.$this->id,[
            'titulo'    => $this->titulo,
            'descricao' => $this->descricao,
            'ativo'     => $this->ativo,
            'data'      => $this->data
          ]);
    }


    /**
     * Method responsible for delete job from database
     *
     * @return boolean
     */
    public function delete()
    {
        return (new Database('vagas'))->delete('id = '.$this->id);
    }
    
    /**
     * Method responsible for fetch jobs from database
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getVagas($where = null, $order = null, $limit = null)
    {
        return (new Database('vagas'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Method responsible for fetch the number of jobs in the database
     *
     * @param string $where
     * @return integer
     */
    public static function countVagas($where = null)
    {
        return (new Database('vagas'))->select($where, null, null, "COUNT(*) as qtd")->fetchObject()->qtd;
    }

    /**
     * Method responsible for fetch one job from database where id == $id
     *
     * @param integer $id
     * @return Vaga
     */

    public static function getVaga($id)
    {
        return (new Database('vagas'))->select('id = '.$id)->fetchObject(self::class);
    }
}
