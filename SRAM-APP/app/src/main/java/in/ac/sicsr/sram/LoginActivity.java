package in.ac.sicsr.sram;

import android.content.DialogInterface;
import android.content.Intent;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

public class LoginActivity extends AppCompatActivity {

    //Back Press Variables
    private static final int TIME_DELAY = 2000;
    private static long back_pressed;
    //.......................................

    EditText prn,pass;
    String PRN, PASS;
    Intent i;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        i=new Intent(getApplicationContext(),selectSemesterPage.class);


    }



    public void loginNow(View v) {



        prn = (EditText) findViewById(R.id.signInPrn);
        pass = (EditText) findViewById(R.id.signInPassword);
        PRN = prn.getText().toString();
        PASS = pass.getText().toString();


        if ((PRN.trim()).equals("") || (PASS.trim()).equals("")) {
            Toast.makeText(this, "Please Fill both the Fields!", Toast.LENGTH_SHORT).show();
        }
        else {

            String url = "http://192.168.43.13/dSRAM/dbget.php?prn=" + PRN + "&password=" + PASS;


            final RequestQueue rq= Volley.newRequestQueue(LoginActivity.this);
            StringRequest sr=new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    if(response.equals("invalid")){
                        Toast.makeText(LoginActivity.this, "Invalid User! Please Enter Correct Details. "+response, Toast.LENGTH_SHORT).show();
                    }
                    else {
                        Toast.makeText(LoginActivity.this, "Welcome " + response, Toast.LENGTH_SHORT).show();
                        i.putExtra("name", response);
                        i.putExtra("prn", PRN);
                        gotoTabbedPage();

                    }

                    rq.stop();

                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(LoginActivity.this, "Something is Wrong", Toast.LENGTH_SHORT).show();
                    error.printStackTrace();
                    rq.stop();
                }
            });

            rq.add(sr);




        }


    }

    public void gotoTabbedPage(){
        startActivity(i);
        finish();
    }


    public void gotoSignUpPage(View v){
        Intent k = new Intent(getApplicationContext(),SignUpActivity.class);
        startActivity(k);

    }


    @Override
    public void onBackPressed() {
        if (back_pressed + TIME_DELAY > System.currentTimeMillis()) {
            super.onBackPressed();
        } else {
            Toast.makeText(getBaseContext(), "Press once again to exit!",
                    Toast.LENGTH_SHORT).show();
        }
        back_pressed = System.currentTimeMillis();
    }

}
