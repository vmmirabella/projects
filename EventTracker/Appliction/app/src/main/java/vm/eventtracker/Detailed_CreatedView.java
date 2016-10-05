package vm.eventtracker;

import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.TextView;

import vm.eventtracker.Menu_Items.Help;
import vm.eventtracker.Menu_Items.Settings;
import vm.eventtracker.R;

//inspiration for runOnUiThreads from:
// https://stackoverflow.com/questions/11254523/android-runonuithread-explanation
//displays a more detailed view about a user created event
public class Detailed_CreatedView extends AppCompatActivity {

    private Bundle extras;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        loadTheme();
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detailed_created_view);

        extras = getIntent().getExtras();

        TextView eventName = (TextView) findViewById(R.id.createdDetailed_EventName);
        TextView beginShow = (TextView) findViewById(R.id.createdDetailed_BeginShow);
        TextView timeBegin = (TextView) findViewById(R.id.createdDetailed_TimeBegin);
        TextView longDesc = (TextView) findViewById(R.id.createdDetailed_LongDesc);
        TextView address = (TextView) findViewById(R.id.createdDetailed_Address);

        eventName.setText(CheckNull("EventName"));
        beginShow.setText(CheckNull("DateBeginShow"));
        timeBegin.setText(CheckNull("TimeBegin") + "   -  " + CheckNull("TimeEnd"));
        address.setText(CheckNull("Address"));
        longDesc.setText(CheckNull("LongDesc"));

    }

    //loads theme from SharedPreferences, used before super.oncreate
    public void loadTheme() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    //inspired by:https://stackoverflow.com/questions/15025369/changing-the-theme-of-an-android-app-using-preferences
                    SharedPreferences prefTheme = getSharedPreferences("Themes", 0);
                    String themeReturned = prefTheme.getString("LightDark", "ThemeDark");
                    if (themeReturned.equals("ThemeDark"))
                        setTheme(R.style.ThemeDark);
                    else
                        setTheme(R.style.ThemeLight);
                } catch (final Exception ex) {
                    // Log.i("sortViewEntries", "Exception in thread");
                }
            }
        });
    }

    //checks if a string is null. If null returns the string as "No Specification". If not null returns the string
    public String CheckNull(String s) {
        String check = extras.getString(s);
        if (check == null || check.isEmpty())
            return "No Specification";

        return check;
    }

    //when the activity is restarted, mainly used to make sure the proper theme is on
    @Override
    protected void onRestart() {
        super.onRestart();
        finish();
        startActivity(getIntent());
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_detailed_created_view, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            Intent intent = new Intent(Detailed_CreatedView.this, Settings.class);
            startActivity(intent);
            return true;
        } else if (id == R.id.actionbar_help) {
            Intent intent = new Intent(Detailed_CreatedView.this, Help.class);
            startActivity(intent);
        }

        return super.onOptionsItemSelected(item);
    }
}
