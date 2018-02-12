<?php

class ZCRMUserCustomizeInfo
{
	private $notesDesc=null;
	private $isToShowRightPanel=null;
	private $isBcView=null;
	private $isToShowHome=null;
	private $isToShowDetailView=null;
	private $unpinRecentItem=null;
	
	private function __construct()
	{
		
	}
	
	public static function getInstance()
	{
		return new ZCRMUserCustomizeInfo();
	}

    /**
     * notesDesc
     * @return String
     */
    public function getNotesDesc(){
        return $this->notesDesc;
    }

    /**
     * notesDesc
     * @param String $notesDesc
     * @return ZCRMUserCustomizeInfo
     */
    public function setNotesDesc($notesDesc){
        $this->notesDesc = $notesDesc;
    }

    /**
     * isToShowRightPanel
     * @return boolean
     */
    public function isToShowRightPanel(){
        return $this->isToShowRightPanel;
    }

    /**
     * isToShowRightPanel
     * @param boolean $isToShowRightPanel
     */
    public function setIsToShowRightPanel($isToShowRightPanel){
        $this->isToShowRightPanel = $isToShowRightPanel;
    }

    /**
     * isBcView
     * @return boolean
     */
    public function isBcView(){
        return $this->isBcView;
    }

    /**
     * isBcView
     * @param boolean $isBcView
     */
    public function setBcView($isBcView){
        $this->isBcView = $isBcView;
    }

    /**
     * isToShowHome
     * @return boolean
     */
    public function isToShowHome(){
        return $this->isToShowHome;
    }

    /**
     * isToShowHome
     * @param boolean $isToShowHome
     */
    public function setIsToShowHome($isToShowHome){
        $this->isToShowHome = $isToShowHome;
    }

    /**
     * isToShowDetailView
     * @return boolean
     */
    public function isToShowDetailView(){
        return $this->isToShowDetailView;
    }

    /**
     * isToShowDetailView
     * @param boolean $isToShowDetailView
     */
    public function setIsToShowDetailView($isToShowDetailView){
        $this->isToShowDetailView = $isToShowDetailView;
    }

    /**
     * unpinRecentItem
     * @return boolean
     */
    public function getUnpinRecentItem(){
        return $this->unpinRecentItem;
    }

    /**
     * unpinRecentItem
     * @param boolean $unpinRecentItem
     */
    public function setUnpinRecentItem($unpinRecentItem){
        $this->unpinRecentItem = $unpinRecentItem;
    }

}
?>