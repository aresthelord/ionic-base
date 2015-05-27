<?php

class ModelContent {
	
	protected $id ;
	
	protected $header;
	
	protected $content;
	
	protected $img;
	
	protected $active;

    protected $page;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }
	


	public function get($id,$db) {
		$sql = "SELECT id,header, content, img, active ,page FROM content where id = :id ";
    try { 

		$stmt = $db->prepare($sql);
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $result;
    } catch(PDOException $e) {
        throw $e;
        
    }
	}
	
	public function getAll($db) {
        $sql = "SELECT id,header, content, img, active ,page FROM content";
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch(PDOException $e) {
            throw $e;

        }
	}


	
	public function save($photos , $db) {
		 $sql = "INSERT INTO photos (header, content, img, active ,page) VALUES (:header, :content, :img, :active , :page)";
    try {
		$stmt = $db->prepare($sql);
        $stmt->bindParam('header', $photos->header, PDO::PARAM_STR);
        $stmt->bindParam('content', $photos->content, PDO::PARAM_STR);
        $stmt->bindParam('img', $photos->img ,PDO::PARAM_STR);
        $stmt->bindParam('active', $photos->active, PDO::PARAM_BOOL);
        $stmt->bindParam('page', $photos->page, PDO::PARAM_INT);
        $stmt->execute();
        $photos->id = $db->lastInsertId();
		return $photos;
	} catch(PDOException $e) {
        //echo '{"error":{"text":"'. $e->getMessage() .'"}}';
		throw $e;
        //serviceResponse(null, $error->getMessage());
    }
	}
	
	
}