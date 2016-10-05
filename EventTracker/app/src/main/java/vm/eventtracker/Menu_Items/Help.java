package vm.eventtracker.Menu_Items;

import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;

import vm.eventtracker.R;

//inspiration for runOnUiThreads from:
// https://stackoverflow.com/questions/11254523/android-runonuithread-explanation
public class Help extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        loadTheme();
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_help);
    }

    //loads the theme as a thread, used before super.onCreate - doesn't work if used after
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

    //if user goes to settings from Help and then trys to return it will load the theme
    public void onRestart() {
        super.onRestart();
        finish();
        startActivity(getIntent());
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_help, menu);
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
            Intent intent = new Intent(Help.this, Settings.class);
            startActivity(intent);
            return true;
        }

        return super.onOptionsItemSelected(item);
    }
}
