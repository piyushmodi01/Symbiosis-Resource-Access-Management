package in.ac.sicsr.sram;

import android.content.DialogInterface;
import android.content.Intent;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.w3c.dom.Text;

public class SignUpActivity extends AppCompatActivity {

    AlertDialog.Builder builder;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_up);
        builder=new AlertDialog.Builder(SignUpActivity.this);
    }

    public void gotoSignInPage(View v) {
        Intent i = new Intent(getApplicationContext(), LoginActivity.class);
        startActivity(i);

    }

    public void doSignUpHere(View v) {
        //TODO SignUP Code Here!

        //Checking if Data Entered is Correct or Not!

        String prn, name, pass;
        prn = ((EditText) findViewById(R.id.editTextPRN)).getText().toString();
        name = ((EditText) findViewById(R.id.editTextName)).getText().toString();
        pass = ((EditText) findViewById(R.id.editTextPassword)).getText().toString();

        String errorMsg = "1";

        if(prn.trim().isEmpty() || name.trim().isEmpty() || pass.trim().isEmpty()){
            errorMsg="Please Fill All the Fields.";

        }
        else if (!(prn.trim().length() == 11) ) {
            errorMsg = "Invalid PRN entered!";

        } else {

            String courseID = prn.substring(5, 8);
            String collegeID = prn.substring(2, 5);

            if (collegeID.equals("030")) {

                if (courseID.equals("121") || courseID.equals("122")) {

                    if (!(prn.startsWith("14") || prn.startsWith("15") || prn.startsWith("16"))) {

                        errorMsg = "You are not the student of this Institute.";
                    }
                } else if (courseID.equals("141") || courseID.equals("142")) {

                    if (!(prn.startsWith("15") || prn.startsWith("16"))) {

                        errorMsg = "You are not the student of this Institute.";
                    }
                } else {

                    errorMsg = "Invalid Course. Check You PRN.";
                }

            } else {

                errorMsg = "Only SICSR Students are allowed to Register on this APP.";
            }
        }






        if(errorMsg.equals("1")){
            //If Every Field is filled Perfectly!

            //Converting Space in between Name to %20
            name=name.replaceAll("\\s","%20");

            Toast.makeText(this, ""+name, Toast.LENGTH_SHORT).show();
            String url="http://192.168.43.13/dSRAM/dbset.php?key="+pass+"&sname="+name+"&prn="+prn+"";


            StringRequest stringRequest=new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {

                    if(response.startsWith("Duplicate")) {
                        response = "Record already in Database!";
                    }

                    builder.setMessage("Server Response: "+response);
                    builder.setPositiveButton("OK!", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            EditText prn=(EditText)findViewById(R.id.editTextPRN);
                            EditText name=(EditText)findViewById(R.id.editTextName);
                            EditText pass=(EditText)findViewById(R.id.editTextPassword);

                            prn.setText("");
                            name.setText("");
                            pass.setText("");



                        }
                    });


                    AlertDialog alertDialog= builder.create();
                    alertDialog.show();
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {

                }
            });
            
            RequestQueue rq=Volley.newRequestQueue(this);
            rq.add(stringRequest);

        }
        else{
            Toast.makeText(this, "" + errorMsg, Toast.LENGTH_SHORT).show();
        }


    }


}

