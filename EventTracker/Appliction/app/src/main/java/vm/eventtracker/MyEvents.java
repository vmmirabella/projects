package vm.eventtracker;


import android.app.AlertDialog;
import android.app.NotificationManager;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.SharedPreferences;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.support.v4.app.NotificationCompat;
import android.support.v4.content.LocalBroadcastManager;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.ContextMenu;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.Collections;
import java.util.List;
import java.util.Locale;
import java.util.TimeZone;

import vm.eventtracker.Adapters.MyEventsAdapter;
import vm.eventtracker.DatabaseClasses.EventDBHandler;
import vm.eventtracker.Helpers.DateComparator;
import vm.eventtracker.Helpers.Service;
import vm.eventtracker.Menu_Items.Help;
import vm.eventtracker.Menu_Items.Settings;
import vm.eventtracker.Parser_Classes.ViewEntry;

//inspiration for runOnUiThreads from:
// https://stackoverflow.com/questions/11254523/android-runonuithread-explanation
public class MyEvents extends AppCompatActivity {

    private MyEventsAdapter listadapter;
    private List<ViewEntry> viewEntries;
    private int notificationCount;
    private ListView lv;
    private EventDBHandler dbHandler;
    private SQLiteDatabase sqLiteDatabase;
    private SharedPreferences prefTheme, prefNotification, prefResume;
    private String themeReturned, resumeReturned;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        loadTheme();
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_my_events);

        dbHandler = new EventDBHandler(getApplicationContext());
        sqLiteDatabase = dbHandler.getReadableDatabase();

        lv = (ListView) findViewById(R.id.myEventsList);

        listadapter = new MyEventsAdapter(getApplicationContext(), R.layout.listview_layout, themeReturned);

        populateEvents();//loads all events from the DB into listview
        preferences(); // loads preferences. Sends notifications if user turned them on/default

        //Navigation buttons to each activity
        Button myEvents_RefreshButton = (Button) findViewById(R.id.myEvents2);
        Button EventsFestival_Button = (Button) findViewById(R.id.EventFestival);

        myEvents_RefreshButton.setVisibility(View.VISIBLE);
        EventsFestival_Button.setVisibility(View.VISIBLE);

        myEvents_RefreshButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
                startActivity(getIntent());
            }
        });

        EventsFestival_Button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MyEvents.this, Events_and_Festivals.class);
                startActivity(intent);
            }
        });

        //register context menu for Edit and Delete
        registerForContextMenu(lv);

        //list view on click
        lv.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

                ViewEntry viewEntry = (ViewEntry) lv.getItemAtPosition(position);

                setExtras(viewEntry);//function call to set all extras from viewEntry item as well as sending the intent
            }
        });


        //user can click either the button or text to go to create
        final ImageButton createButton = (ImageButton) findViewById(R.id.CreateImageButton);
        createButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MyEvents.this, Add_Edit_EventForm.class);
                startActivity(intent);
            }
        });
        //if user clicks the text beside the button it was also redirect them
        TextView CreateText = (TextView) findViewById(R.id.CreateEventTag);
        CreateText.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MyEvents.this, Add_Edit_EventForm.class);
                startActivity(intent);
            }
        });
    }

    //Loads user preference for notifications. Also makes sure if notifications are turned on
    // they only happen once (unless app is closed and started again
    public void preferences() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    prefNotification = getSharedPreferences("Notify", 1);
                    String notifyReturned = prefNotification.getString("Notification", "On");

                    prefResume = getSharedPreferences("resumeEvent", 2);
                    resumeReturned = prefResume.getString("Resume", "On");

                    //if user didn't turn off notifications and on first load of activity
                    if (notifyReturned.equals("On") && !resumeReturned.equals("Off"))
                        sendNotification();

                    //makes sure notifications are turned off until the app has been closed (onDestory)
                    if (resumeReturned.equals("On")) {
                        prefResume = getSharedPreferences("resumeEvent", 2);
                        SharedPreferences.Editor editor = prefResume.edit();
                        editor.putString("Resume", "Off");
                        editor.apply();
                    }
                } catch (final Exception ex) {
                    // Log.i("sortViewEntries", "Exception in thread");
                }
            }
        });

    }

    //loads the theme as a thread, used before super.onCreate() - doesn't work if used after
    public void loadTheme() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    //inspired by:https://stackoverflow.com/questions/15025369/changing-the-theme-of-an-android-app-using-preferences
                    prefTheme = getSharedPreferences("Themes", 0);
                    themeReturned = prefTheme.getString("LightDark", "ThemeDark");
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

    //sets extra Bundle when passing information to another activity
    private void setExtras(final ViewEntry viewEntry) {
        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    Intent intent;
                    Bundle extras = new Bundle();

                    //if Event is not user created send to Detailed_View
                    if (viewEntry.getEDByName("Type").getText().equals("Tracked")) {
                        intent = new Intent(MyEvents.this, Detailed_View.class);
                        String[] keys = getResources().getStringArray(R.array.keys);
                        for (String key : keys) {
                            switch (key) {
                                case "unid":
                                    extras.putString(key, viewEntry.unid);
                                    break;
                                default:
                                    extras.putString(key, viewEntry.getEDByName(key).getText());
                                    break;
                            }
                        }

                    } else {//if Event is user created send to Detailed_CreatedView
                        intent = new Intent(MyEvents.this, Detailed_CreatedView.class);
                        extras.putString("EventName", viewEntry.getEDByName("EventName").getText());
                        extras.putString("DateBeginShow", viewEntry.getEDByName("DateBeginShow").getText());
                        extras.putString("TimeBegin", viewEntry.getEDByName("TimeBegin").getText());
                        extras.putString("TimeEnd", viewEntry.getEDByName("TimeEnd").getText());
                        extras.putString("Address", viewEntry.getEDByName("Address").getText());
                        extras.putString("LongDesc", viewEntry.getEDByName("LongDesc").getText());
                    }

                    intent.putExtras(extras);
                    startActivity(intent);

                } catch (final Exception ex) {
                    // Log.i("PopulateDays", "Exception in thread");
                }
            }
        });

    }

    //thread to populate listview with all events in DB
    private void populateEvents() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    viewEntries = new ArrayList<ViewEntry>();
                    //code copied from: https://www.youtube.com/watch?v=V4FqE83K1n0
                    Cursor cursor = dbHandler.getViewEntryCursor(sqLiteDatabase);
                    if (cursor.moveToFirst()) {
                        String[] list = getResources().getStringArray(R.array.keys);
                        do {
                            ViewEntry viewEntry = new ViewEntry();
                            for (int i = 0; i < list.length; i++) {

                                if (i != 0) {
                                    ViewEntry.EntryData ed = new ViewEntry.EntryData();
                                    ed.setName(list[i]);
                                    ed.setText(cursor.getString(i));
                                    viewEntry.entryData.put(list[i], ed);
                                } else
                                    viewEntry.unid = cursor.getString(i);
                            }
                            viewEntries.add(viewEntry);

                        } while (cursor.moveToNext());
                    }
                    sortViewEntries();
                    for (int i = 0; i < viewEntries.size(); i++)
                        listadapter.add(viewEntries.get(i));
                    lv.setAdapter(listadapter);

                } catch (final Exception ex) {
                    // Log.i("PopulateDays", "Exception in thread");
                }
            }
        });
    }


    //sorts all viewEntry objects in ascending order
    private void sortViewEntries() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    Collections.sort(viewEntries, new DateComparator());
                } catch (final Exception ex) {
                    // Log.i("sortViewEntries", "Exception in thread");
                }
            }
        });
    }

    //Will send a notification to the user if there any events coming up in the next 3 days
    //this function will only be called if it meets the initial flags in onCreate(). If the user has selected
    //notifications on (on by default) and the activity isn't being resumed (to avoid multiple notifications)
    private void sendNotification() {

        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    ArrayList<String> months = new ArrayList<String>();
                    String[] MonthsArray = getResources().getStringArray(R.array.months);//gets an array that contains all the months

                    for (String aMonthsArray : MonthsArray) {
                        months.add(aMonthsArray.substring(0, 3));
                    }

                    for (int i = 0; i < viewEntries.size(); i++) {

                        // example of DateBeginShow format: "Nov 13, 2015"
                        String check = viewEntries.get(i).getEDByName("DateBeginShow").getText();
                        int coma = check.indexOf(",", 4);
                        int space = check.indexOf(" ", 0);
                        String monName = check.substring(0, 3);

                        Calendar cal = Calendar.getInstance(Locale.getDefault());
                        //calendar values contains the current month, day and year
                        int calMonth = cal.get(Calendar.MONTH);
                        int calDay = cal.get(Calendar.DAY_OF_MONTH);
                        int calYear = cal.get(Calendar.YEAR);

                        //values containing month, day and year from the current (i) event
                        int monthNum = months.indexOf(monName);
                        int day = Integer.valueOf(check.substring(space + 1, coma));
                        space = check.indexOf(" ", coma);
                        int year = Integer.valueOf(check.substring(space + 1));

                        day -= calDay;//ie.5-4 = 1

                        //checks to see if there is an event coming up within the next 3 days
                        if (calYear == year && calMonth == monthNum && (day <= 3 && day >= 0))
                            notificationCount++;
                    }

                } catch (final Exception ex) {
                    //  Log.i("sendNotification", "Exception in thread");
                }
            }
        });

        //if at least one notification has been found send a notification to the user on startup
        if (notificationCount > 0) {
            Intent intent = new Intent(MyEvents.this, Service.class);
            startService(intent);

            IntentFilter filter = new IntentFilter("eventTracker.notification.myEvents");
            LocalBroadcastManager.getInstance(MyEvents.this).registerReceiver(new ServiceListener(), filter);

        }

    }

    //Context menu with 2 options, one to delete an item and the other to edit
    public void onCreateContextMenu(ContextMenu menu, View v, ContextMenu.ContextMenuInfo menuInfo) {
        super.onCreateContextMenu(menu, v, menuInfo);
        menu.setHeaderTitle("Select The Action");
        menu.add(0, v.getId(), 0, "Edit");
        menu.add(0, v.getId(), 1, "Delete");
    }

    @Override //contains code for when either menu item is selected
    public boolean onContextItemSelected(final MenuItem item) {
        if (item.getOrder() == 0)//Edit
        {
            AdapterView.AdapterContextMenuInfo info = (AdapterView.AdapterContextMenuInfo) item.getMenuInfo();
            int listPosition = info.position;
            ViewEntry v = (ViewEntry) lv.getItemAtPosition(listPosition);

            //only a user created event may be edited, if the item is 'tracked' then the event is not user created
            if (v.getEDByName("Type").getText().equals("Tracked"))
                Toast.makeText(getApplicationContext(), "Only events you have created may be edited", Toast.LENGTH_LONG).show();
            else {
                Intent intent = new Intent(this, Add_Edit_EventForm.class);
                Bundle extras = new Bundle();

                extras.putString("EventName", v.getEDByName("EventName").getText());
                extras.putString("DateBeginShow", v.getEDByName("DateBeginShow").getText());
                extras.putString("TimeBegin", v.getEDByName("TimeBegin").getText());
                extras.putString("TimeEnd", v.getEDByName("TimeEnd").getText());
                extras.putString("Address", v.getEDByName("Address").getText());
                extras.putString("LongDesc", v.getEDByName("LongDesc").getText());
                extras.putString("unid", v.unid);
                intent.putExtras(extras);
                startActivity(intent);
            }

        } else if (item.getOrder() == 1) //Delete
        {
            AdapterView.AdapterContextMenuInfo info = (AdapterView.AdapterContextMenuInfo) item.getMenuInfo();
            int listPosition = info.position;
            final ViewEntry v = (ViewEntry) lv.getItemAtPosition(listPosition);

            String eventName = v.getEDByName("EventName").getText();
            if (eventName == null || eventName.isEmpty())
                eventName = "this entry";

            //code copied from: https://stackoverflow.com/questions/2115758/how-to-display-alert-dialog-in-android
            //display an alert dialog to ask if the user is sure they wish to delete the item
            new AlertDialog.Builder(MyEvents.this)
                    .setMessage("Are you sure you want to delete " + eventName + "?")
                    .setPositiveButton("Delete", new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int which) {

                            Boolean check = dbHandler.DeleteViewEntry(v.unid, sqLiteDatabase);
                            dbHandler.close();

                            if (check) {
                                Intent intent = new Intent(getIntent());
                                finish();
                                startActivity(intent);
                                Toast.makeText(getApplicationContext(), "Deleted " + v.getEDByName("EventName").getText(), Toast.LENGTH_LONG).show();
                            }

                        }
                    })
                    .setNegativeButton(android.R.string.no, new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int which) {
                            // do nothing
                        }
                    })
                    .show();
        } else {
            return false;
        }
        return true;
    }

    //listener that will send the notification broadcast if sendNotification() was called and there are events within 3 days
    //Sends a notification with the number of events coming up
    class ServiceListener extends BroadcastReceiver {
        @Override
        public void onReceive(Context context, Intent intent) {
            NotificationCompat.Builder mBuilder =
                    new NotificationCompat.Builder(context)
                            .setSmallIcon(android.R.drawable.sym_def_app_icon)
                            .setContentTitle("Event Tracker")
                            .setContentText(notificationCount + " events/festivals are coming up");
            NotificationManager mNotificationManager =
                    (NotificationManager) getSystemService(Context.NOTIFICATION_SERVICE);
            mNotificationManager.notify(0, mBuilder.build());

            // Log.d("Service", "Received broadcast intent");
        }
    }


    //If the activity is being resumed, such if the user goes to Settings and changes theme then clicks back
    //to return to this actvity it will start the activity again to get the theme but add a "flag" so that
    //notifications won't fire off every time the user returns to MyEvents
    @Override
    public void onRestart() {
        super.onRestart();
        if (resumeReturned.equals("On")) {
            prefResume = getSharedPreferences("resumeEvent", 2);
            SharedPreferences.Editor editor = prefResume.edit();
            editor.putString("Resume", "Off");
            editor.apply();
        }
        finish();
        startActivity(getIntent());
    }

    //When the app has been closed it will release the previous flag and set it back to ON so that
    // when the app starts it will send a notification (if the user hasn't chosen to turn it off)
    @Override
    protected void onDestroy() {
        SharedPreferences.Editor editor = prefResume.edit();
        editor.putString("Resume", "On");
        editor.apply();
        dbHandler.close();
        sqLiteDatabase.close();
        super.onDestroy();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_my_events, menu);
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
            Intent intent = new Intent(MyEvents.this, Settings.class);
            startActivity(intent);
            return true;
        } else if (id == R.id.actionbar_help) {
            Intent intent = new Intent(MyEvents.this, Help.class);
            startActivity(intent);
        }

        return super.onOptionsItemSelected(item);
    }


}
