package vm.eventtracker.Menu_Items;

import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.CompoundButton;
import android.widget.Switch;
import android.widget.Toast;

import vm.eventtracker.R;

//inspiration for runOnUiThreads from:
// https://stackoverflow.com/questions/11254523/android-runonuithread-explanation
public class Settings extends AppCompatActivity {

    private SharedPreferences themePref, notifyPref;
    private String dataReturned;
    private Switch switchNotifications, switchThemes;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        loadTheme();//loads theme for layout
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_settings);

        setSwitch();//sets both switches (notification and theme) using a thread

        //when user clicks the on the theme switch trying to change themes
        switchThemes.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                //inspired by: https://stackoverflow.com/questions/22178414/what-are-the-preferencemanager-and-sharedpreference-classes-used-for-in-android
                SharedPreferences.Editor editor = themePref.edit();
                //Puts the user's preference for Light theme or Dark theme into SharedPreferences
                if (isChecked)
                    editor.putString("LightDark", "ThemeLight");
                else
                    editor.putString("LightDark", "ThemeDark");
                editor.apply();

                //notifies the user that if a previous activity hasn't been updated with the chosen theme to refresh that activity
                Toast.makeText(getApplicationContext(), "*Refresh previous activates if theme doesn't update on them*", Toast.LENGTH_LONG).show();

                //refreshes the current activity which will refresh with the newly chosen theme
                Intent intent = getIntent();
                finish();
                startActivity(intent);

            }
        });

        //when the user uses the notification switch
        switchNotifications.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                //inspired by: https://stackoverflow.com/questions/22178414/what-are-the-preferencemanager-and-sharedpreference-classes-used-for-in-android
                SharedPreferences.Editor editor = notifyPref.edit();
                //Puts the user's preference for notifications into SharedPreferences; on or off
                if (isChecked)
                    editor.putString("Notification", "On");
                else
                    editor.putString("Notification", "Off");
                editor.apply();
            }
        });
    }

    //sets switches to either on or off depending on what the user had previously selected (taken from SharedPreferences), else default
    public void setSwitch() {
        notifyPref = getSharedPreferences("Notify", 1);
        String notifyReturned = notifyPref.getString("Notification", "On");

        switchNotifications = (Switch) findViewById(R.id.notify_switch);
        switchThemes = (Switch) findViewById(R.id.theme_switch);

        //Sets the switchs to be either on or off depending on previous user preference choice
        if (!notifyReturned.equals("On"))
            switchNotifications.setChecked(false);
        else
            switchNotifications.setChecked(true);

        if (dataReturned.equals("ThemeDark"))
            switchThemes.setChecked(false);
        else
            switchThemes.setChecked(true);

    }

    //loads theme from SharedPreferences using a thread to reduce load on main UI thread
    public void loadTheme() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    //inspired by:https://stackoverflow.com/questions/15025369/changing-the-theme-of-an-android-app-using-preferences
                    themePref = getSharedPreferences("Themes", 0);
                    dataReturned = themePref.getString("LightDark", "ThemeDark");
                    if (dataReturned.equals("ThemeDark"))
                        setTheme(R.style.ThemeDark);
                    else
                        setTheme(R.style.ThemeLight);
                } catch (final Exception ex) {
                    // Log.i("sortViewEntries", "Exception in thread");
                }
            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_settings, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.actionbar_help) {
            Intent intent = new Intent(Settings.this, Help.class);
            startActivity(intent);
        }

        return super.onOptionsItemSelected(item);
    }
}
