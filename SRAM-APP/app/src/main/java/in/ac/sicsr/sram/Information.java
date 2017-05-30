package in.ac.sicsr.sram;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.webkit.WebView;

public class Information extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_information);

    //Loading URLS
        Intent i = getIntent();
        Bundle b=i.getExtras();
        String url=b.getString("url");

        WebView wv=(WebView)findViewById(R.id.webViewUI);
        wv.loadUrl(url);

    }



}
