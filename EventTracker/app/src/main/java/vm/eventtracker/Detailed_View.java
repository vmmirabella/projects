package vm.eventtracker;


import android.content.Intent;
import android.content.SharedPreferences;
import android.database.sqlite.SQLiteDatabase;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import vm.eventtracker.DatabaseClasses.EventDBHandler;
import vm.eventtracker.Menu_Items.Help;
import vm.eventtracker.Menu_Items.Settings;
import vm.eventtracker.Parser_Classes.ViewEntry;

//inspiration for runOnUiThreads from:
// https://stackoverflow.com/questions/11254523/android-runonuithread-explanation
//details a more detailed view of Events and Festivals (objects parsed) items
public class Detailed_View extends AppCompatActivity {

    private Bundle extras;
    private ViewEntry viewEntry;
    private EventDBHandler dbHandler;
    TextView eventName, Location, CategoryList, OrgName, BeginShow, TimeBegin, LongDesc, OrgPhone,
            Intersection, TTC, Performance, Address, MapAddress, EventURL;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        loadTheme();
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detailed_view);

        //get extras from Events and Festivals.
        // If null then activity is being called from MyEvents, which means event is already being tracked
        extras = getIntent().getExtras();
        Button add = (Button) findViewById(R.id.track);
        if (extras.getString("Type") == null)
            add.setVisibility(View.VISIBLE);

        //uses a runnable thread to populate textviews
        populateTextViews();

        dbHandler = new EventDBHandler(this.getApplicationContext());

        //Track button. On Click adds the selected event to the Database, if the item is already in the DB it will not add(duplicates stopped in EventDBHelper)
        add.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                addEntryDB();//uses a thread to add the entry into the DB
                Toast.makeText(getApplicationContext(), viewEntry.getEDByName("EventName").getText() + " has been added to MyEvents and is now being tracked", Toast.LENGTH_LONG).show();
                finish();//closes detailed view and returns to previous activity
            }
        });
    }

    //loads theme from sharedpreferences, used before super.oncreate
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

    //called when the user wants to "Track" an event. Adds the event into the database if it doesn't already exist there
    private void addEntryDB() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    SQLiteDatabase sqLiteDatabase = dbHandler.getWritableDatabase();
                    String[] keys = getResources().getStringArray(R.array.keys);//contains all 'keys' to fields

                    viewEntry = new ViewEntry();

                    //populate viewEntry object
                    for (String key : keys) {
                        ViewEntry.EntryData ed = new ViewEntry.EntryData();
                        ed.setName(key);

                        switch (key) {
                            case "unid":
                                viewEntry.unid = extras.getString(key);
                                break;
                            case "Type":
                                ed.setText("Tracked");
                                break;
                            default:
                                ed.setText(extras.getString(key));
                                break;
                        }

                        if (!key.equals("unid"))
                            viewEntry.entryData.put(key, ed);
                    }

                    dbHandler.addViewEntry(viewEntry, sqLiteDatabase);//add entry to DB which will be displayed on MyEvents
                    dbHandler.close();
                } catch (final Exception ex) {
                    // Log.i("sortViewEntries", "Exception in thread");
                }
            }
        });

    }


    //Thread used to populate all Textviews, if there are null values they are replaced with "Not specified"
    private void populateTextViews() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {

                    eventName = (TextView) findViewById(R.id.Detailed_EventName);
                    Location = (TextView) findViewById(R.id.Detailed_Location);
                    CategoryList = (TextView) findViewById(R.id.Detailed_Category);
                    OrgName = (TextView) findViewById(R.id.Detailed_OrgName);
                    BeginShow = (TextView) findViewById(R.id.Detailed_BeginShow);
                    TimeBegin = (TextView) findViewById(R.id.Detailed_TimeBegin);
                    LongDesc = (TextView) findViewById(R.id.Detailed_LongDesc);
                    OrgPhone = (TextView) findViewById(R.id.Detailed_OrgContact);
                    Intersection = (TextView) findViewById(R.id.Detailed_Intersection);
                    TTC = (TextView) findViewById(R.id.Detailed_TTC);
                    Performance = (TextView) findViewById(R.id.Detailed_Performance);
                    Address = (TextView) findViewById(R.id.Detailed_Address);
                    MapAddress = (TextView) findViewById(R.id.Detailed_AddressLink);
                    EventURL = (TextView) findViewById(R.id.Detailed_EventLink);

                    eventName.setText(CheckNull("EventName"));
                    CategoryList.setText(CheckNull("CategoryList"));
                    OrgName.setText(CheckNull("PresentedByOrgName"));
                    BeginShow.setText(CheckNull("DateBeginShow") + "  -  " + CheckNull("DateEndShow"));
                    TimeBegin.setText(CheckNull("TimeBegin") + "   -  " + CheckNull("TimeEnd"));
                    String ext = CheckNull("OrgContactExt");
                    if (ext != null)
                        ext += " EXT: ";
                    else
                        ext = "";
                    OrgPhone.setText(CheckNull("OrgContactPhone") + " " + ext + "\n" + CheckNull("OrgContactEMail"));
                    Location.setText(CheckNull("Location"));
                    Address.setText(CheckNull("Address"));
                    LongDesc.setText(CheckNull("LongDesc"));
                    Intersection.setText(CheckNull("Intersection"));
                    TTC.setText(CheckNull("TTC"));
                    Performance.setText(CheckNull("Performance"));
                    MapAddress.setText(CheckNull("MapAddress"));
                    EventURL.setText(CheckNull("EventURL"));

                } catch (final Exception ex) {
                    //  Log.i("PopulateTextViews", "Exception in thread");
                }
            }
        });
    }

    //checks for a string for null, if null returns "Not specified" instead, else returns the string
    public String CheckNull(String s) {
        String check = extras.getString(s);
        if (check == null || check.isEmpty())
            return "Not specified";

        return check;
    }

    //when the activity is restarted (used to make sure the appropriate theme is displayed)
    @Override
    protected void onRestart() {
        super.onRestart();
        finish();
        startActivity(getIntent());
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_detailed_view, menu);
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
            Intent intent = new Intent(Detailed_View.this, Settings.class);
            startActivity(intent);
            return true;
        } else if (id == R.id.actionbar_help) {
            Intent intent = new Intent(Detailed_View.this, Help.class);
            startActivity(intent);
        }

        return super.onOptionsItemSelected(item);
    }
}
