// MoneyCalculator.java
import java.io.*;
import javax.servlet.*;
import javax.servlet.http.*;

public class MoneyCalculator extends HttpServlet {
    
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        
        double income = Double.parseDouble(request.getParameter("income"));
        double expense = Double.parseDouble(request.getParameter("expense"));
        
        double balance = income - expense;
        
        response.setContentType("text/html");
        PrintWriter out = response.getWriter();
        out.println("<html><body>");
        out.println("<h2>Balance Calculation</h2>");
        out.println("<p>Income: " + income + "</p>");
        out.println("<p>Expense: " + expense + "</p>");
        out.println("<p>Balance: " + balance + "</p>");
        out.println("</body></html>");
    }
}