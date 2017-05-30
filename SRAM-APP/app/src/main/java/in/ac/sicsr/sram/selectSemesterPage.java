package in.ac.sicsr.sram;

import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

public class selectSemesterPage extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    String course,prn;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_select_semester_page);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);



        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);

        View header=navigationView.getHeaderView(0);
        TextView nav_name,nav_prn;
        nav_name=(TextView)header.findViewById(R.id.nav_Name);
        nav_prn=(TextView)header.findViewById(R.id.nav_PRN);

        Intent i = getIntent();
        Bundle b=i.getExtras();

        nav_name.setText(b.getString("name"));
        nav_prn.setText(b.getString("prn")+"@sicsr.ac.in");

        prn=b.getString("prn");
        course=prn.substring(5,8);
        if(course.equals("141") || course.equals("142")){
            ImageView sem5=(ImageView)findViewById(R.id.imgSem5);
            ImageView sem6=(ImageView)findViewById(R.id.imgSem6);

            sem5.setVisibility(View.GONE);
            sem6.setVisibility(View.GONE);

        }


        navigationView.setNavigationItemSelectedListener(this);




        //Setting Name and PRN to NAV TextViews






    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }



    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();


        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.ExitFromApp) {


            DialogInterface.OnClickListener dialogClickListener = new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    switch (which){
                        case DialogInterface.BUTTON_POSITIVE:

                            Intent i=new Intent(getApplicationContext(),LoginActivity.class);
                            startActivity(i);
                            finish();
                            
                            break;

                        case DialogInterface.BUTTON_NEGATIVE:
                            //No button clicked
                            break;
                    }
                }
            };

            AlertDialog.Builder builder = new AlertDialog.Builder(this);
            builder.setMessage("Are you sure?").setPositiveButton("Yes", dialogClickListener)
                    .setNegativeButton("No", dialogClickListener).show();






        } else if (id == R.id.aboutSICSR) {
            Intent i = new Intent(getApplicationContext(),Information.class);
            i.putExtra("url","http://sicsr.ac.in/about/sicsr");
            startActivity(i);


        } else if (id == R.id.nav_aboutSIU) {
            Intent i = new Intent(getApplicationContext(),Information.class);
            i.putExtra("url","http://siu.edu.in/about-us.php");
            startActivity(i);

        } else if (id == R.id.aboutMentor) {
            Intent i = new Intent(getApplicationContext(),Information.class);
            i.putExtra("url","https://in.linkedin.com/in/harshadgune");
            startActivity(i);

        }

        else if (id == R.id.nav_fbLink) {
            String url = "https://www.facebook.com/piyushmodi01";
            Intent i = new Intent(Intent.ACTION_VIEW);
            i.setData(Uri.parse(url));
            startActivity(i);


        }

        else if (id == R.id.nav_twitterLink) {
            String url = "https://twitter.com/piyushmodi01";
            Intent i = new Intent(Intent.ACTION_VIEW);
            i.setData(Uri.parse(url));
            startActivity(i);

        }

        else if (id == R.id.nav_gmailLink) {
            Intent intent = new Intent (Intent.ACTION_SEND);
            intent.setType("message/rfc822");
            intent.putExtra(Intent.EXTRA_EMAIL, new String[]{"piyushmodi01@gmail.com"});
            intent.putExtra(Intent.EXTRA_SUBJECT, "SRAM: User Contact");
            intent.setPackage("com.google.android.gm");
            if (intent.resolveActivity(getPackageManager())!=null)
                startActivity(intent);
            else
                Toast.makeText(this,"Gmail App is not installed", Toast.LENGTH_SHORT).show();

        }





        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }


    Intent j;

    public void gotoSem1(View v){
        j=new Intent(getApplicationContext(),semesterCourseView.class);
        j.putExtra("prn",prn);
        j.putExtra("semester","Semester-1");

        startActivity(j);

    }
    public void gotoSem2(View v){
        j=new Intent(getApplicationContext(),semesterCourseView.class);
        j.putExtra("prn",prn);
        j.putExtra("semester","Semester-2");
        startActivity(j);
    }
    public void gotoSem3(View v){
        j=new Intent(getApplicationContext(),semesterCourseView.class);
        j.putExtra("prn",prn);
        j.putExtra("semester","Semester-3");
        startActivity(j);
    }
    public void gotoSem4(View v){
        j=new Intent(getApplicationContext(),semesterCourseView.class);
        j.putExtra("prn",prn);
        j.putExtra("semester","Semester-4");
        startActivity(j);
    }
    public void gotoSem5(View v){
        j=new Intent(getApplicationContext(),semesterCourseView.class);
        j.putExtra("prn",prn);
        j.putExtra("semester","Semester-5");
        startActivity(j);
    }
    public void gotoSem6(View v){
        j=new Intent(getApplicationContext(),semesterCourseView.class);
        j.putExtra("prn",prn);
        j.putExtra("semester","Semester-6");
        startActivity(j);
    }
}
