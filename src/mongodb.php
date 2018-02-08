<?php
namespace ninvfeng;
class mongodb{

    public $mongodb='';

    public $db='';

    public $table='';

    public $filter=[];

    public $option=[];

    public function __construct($table,$db='test',$host="127.0.0.1",$port="27017"){

        //实例化mongodb对象
        $this->mongodb = new \MongoDB\Driver\Manager("mongodb://$host:$port");

        //表
        $this->table=$table;

        //库
        $this->db=$db;
    }

    //返回原生mongodb对象
    public function mongodb(){
        return $this->mongodb;
    }

    //条件
    public function where($where){
        if(is_string($where['_id'])){
            $where['_id']=new \MongoDB\BSON\ObjectID($where['_id']);
        }
        $this->filter=$where;
        return $this;
    }

    //分页
    public function page($page,$num=10){
        $option['sort']=['_id'=>-1];
        $option['limit']=$num;
        $option['skip']=($page-1)*$num;
        $this->option=$option;
        return $this;
    }

    //添加记录
    public function insert($arr){
        $bulk = new \MongoDB\Driver\BulkWrite;
        $bulk->insert($arr);
        return $this->mongodb->executeBulkWrite($this->db.'.'.$this->table, $bulk);
    }

    //删除记录
    public function delete(){
        $bulk = new \MongoDB\Driver\BulkWrite;
        $filter=$this->filter;
        // $filter['limit']=0;
        $bulk->delete($filter);
        $res=$this->mongodb->executeBulkWrite($this->db.'.'.$this->table, $bulk);
        return $res->getDeletedCount();
    }

    //修改记录
    public function update($data){
        $bulk = new \MongoDB\Driver\BulkWrite;
        $bulk->update($this->filter,['$set' => $data],['multi' => false, 'upsert' => false]);
        $writeConcern = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        return $this->mongodb->executeBulkWrite($this->db.'.'.$this->table, $bulk, $writeConcern);
    }

    //查找一条记录
    public function find(){
        $query = new \MongoDB\Driver\Query($this->filter);
        $cursor = $this->mongodb->executeQuery($this->db.'.'.$this->table, $query);
        foreach ($cursor as $document) {
            $res[]=json_decode(json_encode($document),true);
        }
        return $res[0];
    }

    //查找记录
    public function select(){
        $query = new \MongoDB\Driver\Query($this->filter,$this->option);
        $cursor = $this->mongodb->executeQuery($this->db.'.'.$this->table, $query);
        foreach ($cursor as $document) {
            $res[]=json_decode(json_encode($document),true);
        }
        return $res;
    }


    //取一条记录并删除
    public function findAndRemove(){
        $arr = [
            'findAndModify'=>$this->table,
            'query'=>$this->filter,
            'remove'=>true
        ];
        $cmd=new \MongoDB\Driver\Command($arr);
        $cursor = $this->mongodb->executeCommand($this->db, $cmd);
        return $cursor->toArray()[0]->value;
    }

    //统计
    public function count(){
        $arr = [
            'count'=>$this->table,
            'query'=>$this->filter
        ];
        $cmd=new \MongoDB\Driver\Command($arr);
        $cursor = $this->mongodb->executeCommand($this->db, $cmd);
        return $cursor->toArray()[0]->n;
    }

    //调用函数
    public function func($func){
        $arr = [
            "eval" => $func
        ];
        $cmd=new \MongoDB\Driver\Command($arr);
        $cursor = $this->mongodb->executeCommand($this->db, $cmd);
        return $cursor->toArray()[0]->retval;
    }

}
