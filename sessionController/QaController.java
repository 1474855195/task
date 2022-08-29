package modelController.sessionController;

import entities.Knowledge;
import java.io.Serializable;
import java.util.List;
import javax.ejb.EJB;
import javax.enterprise.context.SessionScoped;
import javax.inject.Inject;
import javax.inject.Named;
import sessionBeans.KnowledgeFacadeLocal;

@Named
@SessionScoped
public class QaController implements Serializable {
    @Inject
    modelController.applicationController.KnowledgeController applicationKnowledgeController;
    @EJB
    KnowledgeFacadeLocal knowledgeFacadeLocal;
    private String question;
    private String answer;
    
    public String getQuestion() {
        return question;
    }

    public void setQuestion(String question) {
        this.question = question;
    }


    public String getAnswer() {
        return answer=" ";
    } 
     public void setAnswer(String answer) {
        this.answer = answer;
    }
     
    public void submit() {
         this.answer="答案是"+answer;
    }

}
