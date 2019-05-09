<?php
namespace zcrmsdk\crm\setup\users;

class ZCRMUserCustomizeInfo
{
    
    /**
     * notes description
     *
     * @var string
     */
    private $notesDesc = null;
    
    /**
     * show right panel
     *
     * @var boolean
     */
    private $isToShowRightPanel = null;
    
    /**
     * business card view
     *
     * @var boolean
     */
    private $isBcView = null;
    
    /**
     * show home
     *
     * @var boolean
     */
    private $isToShowHome = null;
    
    /**
     * shown detail view
     *
     * @var boolean
     */
    private $isToShowDetailView = null;
    
    /**
     * shown to right panel
     *
     * @var string
     */
    private $unpinRecentItem = null;
    
    private function __construct()
    {}
    
    /**
     * method to get user customize information
     *
     * @return ZCRMUserCustomizeInfo instance of the ZCRMUserCustomizeInfo
     */
    public static function getInstance()
    {
        return new ZCRMUserCustomizeInfo();
    }
    
    /**
     * method to get the notes description
     *
     * @return String the notes description
     */
    public function getNotesDesc()
    {
        return $this->notesDesc;
    }
    
    /**
     * method to set the notes description
     *
     * @param String $notesDesc the notes desc
     */
    public function setNotesDesc($notesDesc)
    {
        $this->notesDesc = $notesDesc;
    }
    
    /**
     * method to check whether right panel is shown
     *
     * @return boolean true if the right panel is shown else false
     */
    public function isToShowRightPanel()
    {
        return $this->isToShowRightPanel;
    }
    
    /**
     * method to show right panel
     *
     * @param boolean $isToShowRightPanel true to show right panel otherwise false
     */
    public function setIsToShowRightPanel($isToShowRightPanel)
    {
        $this->isToShowRightPanel = $isToShowRightPanel;
    }
    
    /**
     * method to check whether business card view is shown
     *
     * @return boolean true if the business card view is shown else false
     */
    public function isBcView()
    {
        return $this->isBcView;
    }
    
    /**
     * method to show bcview
     *
     * @param boolean $isBcView true to show business card view otherwise false
     */
    public function setBcView($isBcView)
    {
        $this->isBcView = $isBcView;
    }
    
    /**
     * method to check whether home is shown
     *
     * @return boolean true if the home is shown else false
     */
    public function isToShowHome()
    {
        return $this->isToShowHome;
    }
    
    /**
     * method to show home
     *
     * @param boolean $isToShowHome true to show home otherwise false
     */
    public function setIsToShowHome($isToShowHome)
    {
        $this->isToShowHome = $isToShowHome;
    }
    
    /**
     * method to check whether detail view is shown
     *
     * @return boolean true if the detailed view is shown else false
     */
    public function isToShowDetailView()
    {
        return $this->isToShowDetailView;
    }
    
    /**
     * method to show detail view
     *
     * @param boolean $isToShowDetailView true to show detail view otherwise false
     */
    public function setIsToShowDetailView($isToShowDetailView)
    {
        $this->isToShowDetailView = $isToShowDetailView;
    }
    
    /**
     * method get the recent unpinned item
     *
     * @return string the recent unpinned item
     */
    public function getUnpinRecentItem()
    {
        return $this->unpinRecentItem;
    }
    
    /**
     * method set the recent unpinned item
     *
     * @param string $unpinRecentItem the recent unpinned item
     */
    public function setUnpinRecentItem($unpinRecentItem)
    {
        $this->unpinRecentItem = $unpinRecentItem;
    }
}