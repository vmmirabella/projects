package vm.eventtracker;


import android.app.ProgressDialog;
import android.app.usage.UsageEvents;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.os.Bundle;
import android.provider.CalendarContract;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.ExpandableListView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.Collections;
import java.util.HashMap;
import java.util.List;

import vm.eventtracker.Adapters.ExpandableListViewAdapter;
import vm.eventtracker.Helpers.DateComparator;
import vm.eventtracker.Menu_Items.Help;
import vm.eventtracker.Menu_Items.Settings;
import vm.eventtracker.Parser_Classes.LiveFeedParser;
import vm.eventtracker.Parser_Classes.ViewEntry;

//inspiration for runOnUiThreads from:
// https://stackoverflow.com/questions/11254523/android-runonuithread-explanation
public class Events_and_Festivals extends AppCompatActivity {
    private ExpandableListView expandableListView;
    private List<String> ParentList;
    private List<ViewEntry> viewEntries;
    private HashMap<String, List<ViewEntry>> childContent;
    private String dataReturned;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        loadTheme();
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_events_festivals);

        ParentList = new ArrayList<String>();
        sortParents();
        new PostAsync().execute();
    }

    //loads the theme as a thread based on SharedPreferences, used before onCreate() - doesn't work if used after
    public void loadTheme() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    //inspired by:https://stackoverflow.com/questions/15025369/changing-the-theme-of-an-android-app-using-preferences
                    SharedPreferences data = getSharedPreferences("Themes", 0);
                    dataReturned = data.getString("LightDark", "ThemeDark");
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


    //This function adds all the months in a year, starting from the current month to ParentList in order (ie. December, January, February...etc)
    private void sortParents() {
        String[] MonthsArray = getResources().getStringArray(R.array.months);//gets an array that contains all the months
        Calendar cal = Calendar.getInstance();
        int monthPosition = cal.get(Calendar.MONTH);//gets the current month as an integer to be used as a position (ie. November would be 10)
        int i = monthPosition;//will be used to iterate, starting at the current month

        //After i reaches 11 (December) it's next loop will cause it to reset to 0 (January) and fill in the months before the current one
        do {
            if (i <= 11)
                ParentList.add(MonthsArray[i++]);
            else
                i = 0;
        } while (i != monthPosition); // will stop once it reaches the current month
    }

    //uses a thread to populate all children and add them to the appropriate parent and also sorts them in ascending order
    private void returnGroupedChildItems() {

        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    childContent = new HashMap<String, List<ViewEntry>>();
                    List<ViewEntry> jan = new ArrayList<ViewEntry>();
                    List<ViewEntry> feb = new ArrayList<ViewEntry>();
                    List<ViewEntry> mar = new ArrayList<ViewEntry>();
                    List<ViewEntry> apr = new ArrayList<ViewEntry>();
                    List<ViewEntry> may = new ArrayList<ViewEntry>();
                    List<ViewEntry> jun = new ArrayList<ViewEntry>();
                    List<ViewEntry> jul = new ArrayList<ViewEntry>();
                    List<ViewEntry> aug = new ArrayList<ViewEntry>();
                    List<ViewEntry> sep = new ArrayList<ViewEntry>();
                    List<ViewEntry> oct = new ArrayList<ViewEntry>();
                    List<ViewEntry> nov = new ArrayList<ViewEntry>();
                    List<ViewEntry> dec = new ArrayList<ViewEntry>();

                    sortViewEntries();//calls function to sort entries into ascending order
                    for (int i = 0; i < viewEntries.size(); i++) {
                        String check = viewEntries.get(i).getEDByName("DateBeginShow").getText().substring(0, 3);
                        switch (check) {
                            case "Jan":
                                jan.add(viewEntries.get(i));
                                break;
                            case "Feb":
                                feb.add(viewEntries.get(i));
                                break;
                            case "Mar":
                                mar.add(viewEntries.get(i));
                                break;
                            case "Apr":
                                apr.add(viewEntries.get(i));
                                break;
                            case "May":
                                may.add(viewEntries.get(i));
                                break;
                            case "Jun":
                                jun.add(viewEntries.get(i));
                                break;
                            case "Jul":
                                jul.add(viewEntries.get(i));
                                break;
                            case "Aug":
                                aug.add(viewEntries.get(i));
                                break;
                            case "Sep":
                                sep.add(viewEntries.get(i));
                                break;
                            case "Oct":
                                oct.add(viewEntries.get(i));
                                break;
                            case "Nov":
                                nov.add(viewEntries.get(i));
                                break;
                            case "Dec":
                                dec.add(viewEntries.get(i));
                                break;
                        }
                    }

                    //adds all entries into their respective parents(months)
                    for (int i = 0; i < ParentList.size(); i++) {
                        String check = ParentList.get(i).substring(0, 3);
                        switch (check) {
                            case "Jan":
                                childContent.put(ParentList.get(i), jan);
                                break;
                            case "Feb":
                                childContent.put(ParentList.get(i), feb);
                                break;
                            case "Mar":
                                childContent.put(ParentList.get(i), mar);
                                break;
                            case "Apr":
                                childContent.put(ParentList.get(i), apr);
                                break;
                            case "May":
                                childContent.put(ParentList.get(i), may);
                                break;
                            case "Jun":
                                childContent.put(ParentList.get(i), jun);
                                break;
                            case "Jul":
                                childContent.put(ParentList.get(i), jul);
                                break;
                            case "Aug":
                                childContent.put(ParentList.get(i), aug);
                                break;
                            case "Sep":
                                childContent.put(ParentList.get(i), sep);
                                break;
                            case "Oct":
                                childContent.put(ParentList.get(i), oct);
                                break;
                            case "Nov":
                                childContent.put(ParentList.get(i), nov);
                                break;
                            case "Dec":
                                childContent.put(ParentList.get(i), dec);
                                break;
                        }
                    }
                } catch (final Exception ex) {
                    Log.i("PopulateYears", "Exception in thread");
                }
            }
        });

    }

    //sorts ViewEntries, uses the DateComparator class to sort in ascending order
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

    /**
     * Couldn't get this code to work**
     * //moves expand arrow to the right side
     * //code copied from  https://stackoverflow.com/questions/5800426/expandable-list-view-move-group-icon-indicator-to-right
     * //set group expand arrow to the right
     * public int GetDipsFromPixel(float pixels) {
     * // Get the screen's density scale
     * final float scale = getResources().getDisplayMetrics().density;
     * // Convert the dps to pixels, based on density scale
     * return (int) (pixels * scale + 0.5f);
     * }
     */

    //thread class used to parse data and display progress dialog
    class PostAsync extends AsyncTask<Void, Void, Void> {
        private ProgressDialog pd;
        private LiveFeedParser helper;

        //shows a progress dialog to show that this task will take longer then usual to do
        @Override
        protected void onPreExecute() {
            pd = ProgressDialog.show(Events_and_Festivals.this, "One Moment", "Loading Events and Festivals in the Toronto Area ...", true, false);
        }

        //off the main UI thread it will parse the website live and create a list of viewEntry objects
        @Override
        protected Void doInBackground(Void... arg0) {
            helper = new LiveFeedParser(999);
            helper.get();
            viewEntries = helper.getViewEntries();
            return null;
        }

        //after doInBackground has finished proceed with these tasks
        @Override
        protected void onPostExecute(Void result) {
            //removes the progress dialog if it's still showing
            if (pd != null && pd.isShowing())
                pd.dismiss();

            //navigation buttons to reach the main activities
            Button myEvents_Button = (Button) findViewById(R.id.myEvents);
            Button EventsFestivals_Button = (Button) findViewById(R.id.button2);

            myEvents_Button.setVisibility(View.VISIBLE);
            EventsFestivals_Button.setVisibility(View.VISIBLE);

            EventsFestivals_Button.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    finish();
                    startActivity(getIntent());
                }
            });

            //goes to myEvents, and checks to make sure that it doesn't spam the user with notifications
            myEvents_Button.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {

                    Intent intent = new Intent(Events_and_Festivals.this, MyEvents.class);
                    startActivity(intent);
                }
            });


            expandableListView = (ExpandableListView) findViewById(R.id.expandableListView);

            /**Used with other commented out code. Couldn't get this to work
             //code copied from  https://stackoverflow.com/questions/5800426/expandable-list-view-move-group-icon-indicator-to-right
             DisplayMetrics dm = new DisplayMetrics();
             getWindowManager().getDefaultDisplay().getMetrics(dm);
             int width = dm.widthPixels;
             if(android.os.Build.VERSION.SDK_INT < android.os.Build.VERSION_CODES.JELLY_BEAN_MR2) {
             expandableListView.setIndicatorBounds(width-GetDipsFromPixel(35), width-GetDipsFromPixel(5));
             } else {
             expandableListView.setIndicatorBoundsRelative(width-GetDipsFromPixel(35), width-GetDipsFromPixel(5));
             }*/


            returnGroupedChildItems();//uses a thread function to return all children with their appropriate parents
            final ExpandableListViewAdapter expandableListViewAdapter = new ExpandableListViewAdapter(getApplicationContext(), ParentList, childContent, dataReturned);
            expandableListView.setAdapter(expandableListViewAdapter);


            //child onclick
            expandableListView.setOnChildClickListener(new ExpandableListView.OnChildClickListener() {
                @Override
                public boolean onChildClick(ExpandableListView parent, View v, int groupPosition, int childPosition, long id) {

                    //find viewEntry that was clicked
                    ViewEntry viewEntry = (ViewEntry) expandableListView.getItemAtPosition(childPosition + 1);

                    Bundle extras = new Bundle();

                    //array that contains all viewEntry object fields
                    String[] keys = getResources().getStringArray(R.array.keys);

                    //adds all information from the chosen viewEntry object into extras so it can be passed to Detailed_View activity
                    for (String key : keys) {
                        switch (key) {
                            case "unid":
                                extras.putString(key, viewEntry.unid);
                                break;
                            case "Type":
                                extras.putString(key, null);
                                break;
                            default:
                                extras.putString(key, viewEntry.getEDByName(key).getText());
                                break;
                        }
                    }

                    Intent intent = new Intent(Events_and_Festivals.this, Detailed_View.class);
                    intent.putExtras(extras);//passes extras to activity
                    startActivity(intent);

                    return false;
                }
            });
        }

    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
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
            Intent intent = new Intent(Events_and_Festivals.this, Settings.class);
            startActivity(intent);
            return true;
        } else if (id == R.id.actionbar_help) {
            Intent intent = new Intent(Events_and_Festivals.this, Help.class);
            startActivity(intent);
        }
        return super.onOptionsItemSelected(item);
    }

}