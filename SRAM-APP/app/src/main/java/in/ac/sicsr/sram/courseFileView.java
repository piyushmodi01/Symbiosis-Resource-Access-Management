package in.ac.sicsr.sram;

import android.content.Intent;
import android.content.res.Configuration;
import android.net.Uri;
import android.os.Handler;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.util.List;

public class courseFileView extends AppCompatActivity {


    String prn;
    String course;
    String year;
    String semester;
    String tappedCourse;
    String tappedFile;


    private ArrayAdapter<String> listAdapter ;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_course_file_view);


        Intent i = getIntent();
        Bundle b = i.getExtras();


        prn=b.getString("prn");
        course=b.getString("course");
        year=b.getString("year");
        semester=b.getString("semester");
        tappedCourse=b.getString("subject");



        final ListView courseListView=(ListView)findViewById(R.id.fileListView);
        serverJsonData getData=new serverJsonData(this);



        List<String> CourseList=getData.getFiles(course,year,semester,tappedCourse);

        listAdapter=new ArrayAdapter<String>(this,R.layout.course_list_layout,CourseList);
        
        if(listAdapter==null){
            Toast.makeText(this, "NULL!", Toast.LENGTH_SHORT).show();
        }




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
                tappedFile =((TextView)view).getText().toString();


                //What should happen if clicked on FIle!


                Toast.makeText(courseFileView.this, ""+tappedFile, Toast.LENGTH_SHORT).show();

                String fileURL="http://192.168.43.13/dSRAM/sites/default/uploadedFiles/"+course+"/"+year+"/"+semester+"/"+tappedCourse+"/"+tappedFile;
                Intent i=new Intent(Intent.ACTION_VIEW);
                i.setData(Uri.parse(fileURL));
                startActivity(i);

            }
        });



    }

    @Override
    public void onConfigurationChanged(Configuration newConfig) {
        super.onConfigurationChanged(newConfig);
    }
}
