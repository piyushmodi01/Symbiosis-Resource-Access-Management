package in.ac.sicsr.sram;


import android.content.Context;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Iterator;
import java.util.List;

/**
 * Created by piyus on 2/15/2017.
 */

public class serverJsonData {
    private String jsonURL="http://192.168.43.13/dSRAM/sites/default/jsonoutput.php";
    Context c;
    public serverJsonData(Context c) {
        this.c = c;
    }



    List<String> CourseList=new ArrayList<String>();

    public List<String> getCourses(final String courseID, final String year, final String semester){




        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(Request.Method.POST, jsonURL, null, new Response.Listener<JSONObject>() {
            @Override
            public void onResponse(JSONObject response) {
                //Getting List of Subjects Here!
               try {
                JSONObject answer = response.getJSONObject(courseID).getJSONObject(year).getJSONObject(semester);
                Iterator<String> keys=answer.keys();
                   String m;
                   while(keys.hasNext()){
                    String test=keys.next();
                       m = new String(test);
                    CourseList.add(m);

                }


            }catch(Exception e){
                e.printStackTrace();
            }



            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        });

        final RequestQueue rq= Volley.newRequestQueue(c);

        rq.add(jsonObjectRequest);

        return CourseList;
    }














    List<String> fileList=new ArrayList<String>();
    public List<String> getFiles(final String courseID, final String year, final String semester,final String course) {

        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(Request.Method.POST, jsonURL, null, new Response.Listener<JSONObject>() {
            @Override
            public void onResponse(JSONObject response) {
                //Getting List of Subjects Here!
                try {
                    JSONArray answer = response.getJSONObject(courseID).getJSONObject(year).getJSONObject(semester).getJSONArray(course);

                    String m;
                    for (int i = 0 ; i<answer.length();i++){
                        String test=answer.getString(i);
                        m = new String(test);
                        fileList.add(m);

                    }


                }catch(Exception e){
                    e.printStackTrace();
                }



            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        });

        final RequestQueue rq= Volley.newRequestQueue(c);

        rq.add(jsonObjectRequest);


        return fileList;
    }


    }
