package modelController.sessionController;

import entities.Major;
import entities.Majorsubject;
import entities.Subject;
import java.io.Serializable;
import java.util.HashSet;
import java.util.LinkedList;
import java.util.List;
import java.util.Set;
import javax.enterprise.context.SessionScoped;
import javax.faces.model.SelectItem;
import javax.inject.Inject;
import javax.inject.Named;
import modelController.viewerController.MainXhtml_1;
import tools.StaticFields;
import tools.pagination.JsfUtil;

@Named("majorController")
@SessionScoped
public class MajorController extends CommonModelController<Major> implements Serializable {


//    @Inject
//    MajorsubjectController majorsubjectController;
    @Inject
    private MainXhtml_1 mainXhtml;
    @Inject
    private modelController.applicationController.MajorController applicationMajorController;
    @Inject
    private tools.UserMessagor userMessagor;
    @Inject
    private modelController.sessionController.CommonSession commonSession;
    private String searchName;
    private List<Major> searchedMajorList;
    private final String tableName = "major", listpage = "major/List", editpage = "major/Edit",
            viewpage = "major/View", createpage = "major/Create";

    public void setDataModelList() {
        pageOperation.setDataModelList(applicationMajorController.getAllList());
    }
  protected Major current;

    public Major getSelected() {
        if (current == null) {
            selectedItemIndex = -1;
            current = new Major();
        }
        return current;
    }
    //-------------------------------For the search and viewall command button------------------
    public void search() {
        if (null != searchName && searchName.trim().length() > 0) {
            searchedMajorList = new LinkedList<>();
            applicationMajorController.getAllList().forEach((major) -> {
                if (((Major) major).getName().contains(searchName)) {
                    searchedMajorList.add((Major) major);
                }
            });
            pageOperation.refreshData(searchedMajorList);
        }
    }

    public String getSearchName() {
        return searchName;
    }

    public void setSearchName(String searchName) {
        this.searchName = searchName;
    }
  
    public void setSelected(Major current) {
        this.current = current;
        //selectedItemIndex = -1;
    }

//------------------prepare View, edit, list,create------------------
    public void prepareList() {
        pageOperation.refreshData(applicationMajorController.getAllList());
        mainXhtml.setPageName(this.listpage);
    }

    public void prepareView() {
        setSelected( (Major) (getItems().getRowData()));
        selectedItemIndex = pageOperation.getPagination().getPageFirstItem() + getItems().getRowIndex();
        mainXhtml.setPageName(this.viewpage);
    }

    public void prepareCreate() {
        setSelected( new Major());
        selectedItemIndex = -1;
        mainXhtml.setPageName(this.createpage);
    }

    public void create() {
        try {
            //1. check whether the name existed? If true, deny the operation;else continue;
            if (null == applicationMajorController.findByName(current.getName())) {
                applicationMajorController.create(current);
                userMessagor.addMessage(commonSession.getResourceBound().getString("Succeed"));
                //2. Refresh the data
                //current = (Major) (getFacade().getQueryResultList("select * from major where  name='" + current.getName().trim() + "'").get(0));
                pageOperation.refreshData(applicationMajorController.getAllList());
                this.logs(current.getName(), tableName, StaticFields.OPERATIONDELETE);
                prepareCreate();
            } else {
                userMessagor.addMessage(current.getName() + ":" + commonSession.getResourceBound().getString("Already") + " " + commonSession.getResourceBound().getString("Exist"));
            }
        } catch (Exception e) {
            userMessagor.addMessage(commonSession.getResourceBound().getString("Failed") + "controll major 1");
        }
    }

    public void prepareEdit() {
        try {
            setSelected ((Major) getItems().getRowData());
            selectedItemIndex = pageOperation.getPagination().getPageFirstItem() + getItems().getRowIndex();
            mainXhtml.setPageName(this.editpage);
        } catch (Exception e) {//getItems().getRowData() return NoRowAvailableException
            selectedItemIndex = pageOperation.getPagination().getPageFirstItem() + getItems().getRowIndex();
            mainXhtml.setPageName(this.editpage);
        }
    }

    public void update() {
        // majorsubjectController.completeSubjectSelection();
        try {
            applicationMajorController.edit(current);
            pageOperation.refreshData(applicationMajorController.getAllList());
            //publicFields.refreshMajorList(null);
            userMessagor.addMessage(commonSession.getResourceBound().getString("Succeed"));
            mainXhtml.setPageName(this.viewpage);
            this.logs(current.getName(), tableName, StaticFields.OPERATIONUPDATE);
        } catch (Exception e) {
            userMessagor.addMessage(commonSession.getResourceBound().getString("Failed") + "controll major 2");
        }
    }

    public void destroy() {
        current = (Major) getItems().getRowData();
        selectedItemIndex = pageOperation.getPagination().getPageFirstItem() + getItems().getRowIndex();
        performDestroy();
       
        mainXhtml.setPageName(this.listpage);
    }

    private void performDestroy() {
        try {
            applicationMajorController.remove(current);
            userMessagor.addMessage(commonSession.getResourceBound().getString("Succeed"));
            //updateCurrentItem();
            pageOperation.refreshData(applicationMajorController.getAllList());
            this.logs(current.getName(), tableName, StaticFields.OPERATIONDELETE);
             setSelected(null);
        } catch (Exception e) {
            userMessagor.addMessage(commonSession.getResourceBound().getString("Failed") +","
                    + commonSession.getResourceBound().getString("Please")+ commonSession.getResourceBound().getString("Check")+
                     commonSession.getResourceBound().getString("Class")+ commonSession.getResourceBound().getString("And")+
                     commonSession.getResourceBound().getString("Course")+", from "+
                    "controll major 3");
        }
    }

//    private void updateCurrentItem() {
//        int count = applicationMajorController.count();
//        if (selectedItemIndex >= count) {
//            // selected index cannot be bigger than number of items:
//            selectedItemIndex = count - 1;
//            // go to previous page if last page disappeared:
//            if (pageOperation.getPagination().getPageFirstItem() >= count) {
//                pageOperation.getPagination().previousPage();
//            }
//        }
//        if (selectedItemIndex >= 0) {
//            setSelected( (Major) applicationMajorController.findRange(new int[]{selectedItemIndex, selectedItemIndex + 1}).get(0));
//        }
//    }

    //-----------------
    public SelectItem[] getItemsAvailableSelectMany() {
        return JsfUtil.getSelectItems(applicationMajorController.getAllList(), false);
    }

    public SelectItem[] getItemsAvailableSelectOne() {
        return JsfUtil.getSelectItems(applicationMajorController.getAllList(), true);
    }

    private Set<Subject> subjectsOfcurrentMajor = new HashSet<>();

    public Set<Subject> getSubjectsOfSelectedMajor() {
        for (Majorsubject majorsubject : getSelected().getMajorsubjectSet()) {
            subjectsOfcurrentMajor.add(majorsubject.getSubjectid());
        }
        return subjectsOfcurrentMajor;
    }

}
