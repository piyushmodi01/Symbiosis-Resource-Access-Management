package in.ac.sicsr.sram;

import android.content.Intent;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ExpandableListAdapter;
import android.widget.ExpandableListView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

public class semesterCourseView extends AppCompatActivity {


    //Data Fetching Variables
    String prn;
    String course;
    String year;
    String semester;
    String tappedCourse;

    private ArrayAdapter<String> listAdapter ;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_semester_course_view);

        Intent i = getIntent();
        Bundle b = i.getExtras();
        prn = b.getString("prn");
        semester = b.getString("semester");
        course = prn.substring(5, 8); //course in number

        String start = "20" + prn.substring(0, 2);

        //Deciding Course and Year of Term
        if (course.equals("121")) {
            course = "BCA";
            int end = Integer.parseInt(start) + 3;
            year = start + "-" + end;
        } else if (course.equals("122")) {
            course = "BBA";
            int end = Integer.parseInt(start) + 3;
            year = start + "-" + end;
        } else if (course.equals("141")) {
            course = "MBA-IT";
            int end = Integer.parseInt(start) + 2;
            year = start + "-" + end;
        } else if (course.equals("142")) {
            course = "MSC-CA";
            int end = Integer.parseInt(start) + 2;
            year = start + "-" + end;
        }


        //Deciding Year

//       Setting Data to LISTVIEW



        final ListView courseListView=(ListView)findViewById(R.id.courseListView);
        serverJsonData getData=new serverJsonData(this);



        List<String> CourseList=getData.getCourses(course,year,semester);

        listAdapter=new ArrayAdapter<String>(this,R.layout.course_list_layout,CourseList);



        Runnable r = new Runnable() {
            @Override
            public void run(){
                courseListView.setAdapter(listAdapter);
            }
        };

        Handler h = new Handler();
        h.postDelayed(r, 1000);





        courseListView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                tappedCourse =((TextView)view).getText().toString();



                Toast.makeText(semesterCourseView.this, ""+tappedCourse, Toast.LENGTH_SHORT).show();

                Intent i = new Intent(getApplicationContext(),courseFileView.class);
                i.putExtra("prn",prn);
                i.putExtra("course",course);
                i.putExtra("year",year);
                i.putExtra("semester",semester);
                i.putExtra("subject",tappedCourse);

                startActivity(i);

            }
        });






    }
}
