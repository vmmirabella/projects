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
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;
import java.util.TimeZone;
import java.util.UUID;

import vm.eventtracker.DatabaseClasses.EventDBHandler;
import vm.eventtracker.Menu_Items.Help;
import vm.eventtracker.Menu_Items.Settings;
import vm.eventtracker.Parser_Classes.ViewEntry;


//inspiration for runOnUiThreads from:
// https://stackoverflow.com/questions/11254523/android-runonuithread-explanation
public class Add_Edit_EventForm extends AppCompatActivity {

    private SQLiteDatabase sqLiteDatabase;
    private EventDBHandler dbHandler;
    private ViewEntry viewEntry;
    private Spinner spinnerMonth, spinnerDate, spinnerYear;
    private List<String> dateList, yearList;
    private Bundle extras;
    private EditText addEventName, addStartTime, addEndTime, addAddress, addNotes;
    private ArrayAdapter<String> aaDate;
    private boolean populate = false;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        loadTheme();
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_event_form);

        dbHandler = new EventDBHandler(this.getApplicationContext());

        //find all views and set them
        addEventName = (EditText) findViewById(R.id.addEventName);
        addStartTime = (EditText) findViewById(R.id.addStartTime);
        addEndTime = (EditText) findViewById(R.id.addEndTime);
        addAddress = (EditText) findViewById(R.id.addAddress);
        addNotes = (EditText) findViewById(R.id.addNotes);


        //MonthSpinner +thread to populate months
        populateMonths();
        //DateSpinner + thread to populate days
        populateDays();//populate days list on thread
        //YearSpinner + thread to populate years
        populateYears();

        extras = getIntent().getExtras();
        /* If no extras were set then user is trying to add a new event.
           If extras aren't null then user is trying to edit an existing event and textfields
           and spinners will be re-populated with event details*/
        if (extras != null) {
            populate = true;
            repopulateFields();
        }


        spinnerMonth.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                //will update Days according to the Month (ie. November has 30 days)
                //will not reset the date back to 1 when activity loads
                if (!populate) {
                    populateDays();
                    aaDate.notifyDataSetChanged();
                    //sets populate to false so that if the user now chooses a month,
                    // days will be populated with the appropirate number of days within that month
                    populate = false;
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {
            }
        });

        //Save Button
        Button save = (Button) findViewById(R.id.saveButton);
        save.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                addEntry();//add/update entry to DB
            }
        });

        //Cancel Button
        Button cancel = (Button) findViewById(R.id.cancelButton);
        cancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dbHandler.close();
                finish();
            }
        });

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


    //Generates a (fairly) unique key for each user created entry, VERY unlikely to get collisions and is used to identify each event
    //code copied/inspired by: https://stackoverflow.com/questions/20325105/how-to-create-uuid-from-string-in-android
    private String generateUUID() {
        return UUID.randomUUID().toString().replaceAll("-", "");
    }


    //Function will be called if user is trying to edit an existing event. Will repopulate all fields with that event's data
    private void repopulateFields() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    addEventName.setText(extras.getString("EventName"));
                    addStartTime.setText(extras.getString("TimeBegin"));
                    addEndTime.setText(extras.getString("TimeEnd"));
                    addAddress.setText(extras.getString("Address"));
                    addNotes.setText(extras.getString("LongDesc"));

                    //create calender object to help populate spinners with event details
                    Calendar cal = Calendar.getInstance(TimeZone.getDefault());
                    SimpleDateFormat dateFormat = new SimpleDateFormat("MMM d, yyyy");

                    cal.setTime(dateFormat.parse(extras.getString("DateBeginShow")));

                    //sets spinners
                    spinnerMonth.setSelection(cal.get(Calendar.MONTH));
                    spinnerDate.setSelection(cal.get(Calendar.DAY_OF_MONTH) - 1);
                    Calendar thisYear = Calendar.getInstance();
                    int year = cal.get(Calendar.YEAR) - thisYear.get(Calendar.YEAR);
                    spinnerYear.setSelection(year);

                } catch (final Exception ex) {
                    // Log.i("RepopulateFields", "Exception in thread");
                }
            }
        });

    }

    //Uses a thread to populate the month spinner and display it
    private void populateMonths() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    ArrayAdapter<String> aaMonth = new ArrayAdapter<String>(Add_Edit_EventForm.this, android.R.layout.simple_spinner_item, getResources().getStringArray(R.array.months));
                    aaMonth.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                    spinnerMonth = (Spinner) findViewById(R.id.spinnerMonth);
                    spinnerMonth.setAdapter(aaMonth);

                } catch (final Exception ex) {
                    //  Log.i("PopulateMonths", "Exception in thread");
                }
            }
        });

    }

    //Populates day spinner with dates according to the month selected in the month spinner using a thread
    private void populateDays() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {

                    int days;
                    String selected = spinnerMonth.getSelectedItem().toString();
                    switch (selected) {
                        case "April":
                        case "June":
                        case "September":
                        case "November":
                            days = 30;
                            break;
                        case "February":
                            days = 29;
                            break;
                        default:
                            days = 31;
                            break;
                    }
                    if (dateList == null)//acitvity is first loaded
                        dateList = new ArrayList<String>();
                    else
                        dateList.clear();//clears the dateList if it was previously full
                    for (int i = 1; i <= days; i++)
                        dateList.add(String.valueOf(i));

                    aaDate = new ArrayAdapter<String>(Add_Edit_EventForm.this, android.R.layout.simple_spinner_item, dateList);
                    aaDate.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                    spinnerDate = (Spinner) findViewById((R.id.spinnerDate));
                    spinnerDate.setAdapter(aaDate);

                } catch (final Exception ex) {
                    // Log.i("PopulateDays", "Exception in thread");
                }
            }
        });
    }

    //Populates the Years spinner from the current year to 15 years in the future
    private void populateYears() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    yearList = new ArrayList<String>();
                    Calendar cal = Calendar.getInstance();
                    int year = cal.get(Calendar.YEAR);
                    for (int i = 0; i < 15; i++)
                        yearList.add(String.valueOf(year + i));

                    ArrayAdapter<String> aaYear = new ArrayAdapter<String>(Add_Edit_EventForm.this, android.R.layout.simple_spinner_item, yearList);
                    aaYear.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
                    spinnerYear = (Spinner) findViewById((R.id.spinnerYear));
                    spinnerYear.setAdapter(aaYear);

                } catch (final Exception ex) {
                    // Log.i("PopulateYears", "Exception in thread");
                }
            }
        });
    }

    //adds or edits a ViewEntry into the database
    private void addEntry() {
        runOnUiThread(new Runnable() {
            public void run() {
                try {
                    viewEntry = new ViewEntry();
                    String[] keys = getResources().getStringArray(R.array.keys);//contains all fields to be accessed

                    viewEntry = new ViewEntry();

                    //only want specific cases because keys contains ALL fields but user created fields don't use all fields
                    for (String key : keys) {
                        ViewEntry.EntryData ed = new ViewEntry.EntryData();
                        ed.setName(key);
                        switch (key) {
                            case "unid":
                                if (extras != null)
                                    viewEntry.unid = extras.getString("unid");
                                else
                                    viewEntry.unid = generateUUID();
                            case "EventName":
                                ed.setText(addEventName.getText().toString());
                                break;
                            case "DateBeginShow":
                                ed.setText(spinnerMonth.getSelectedItem().toString().substring(0, 3) + " "
                                        + spinnerDate.getSelectedItem().toString() + ", "
                                        + spinnerYear.getSelectedItem().toString());
                                break;
                            case "TimeBegin":
                                ed.setText(addStartTime.getText().toString());
                                break;
                            case "TimeEnd":
                                ed.setText(addEndTime.getText().toString());
                                break;
                            case "Address":
                                ed.setText(addAddress.getText().toString());
                                break;
                            case "LongDesc":
                                ed.setText(addNotes.getText().toString());
                                break;
                            case "Type":
                                ed.setText("Created");
                                break;
                            default:
                                ed.setText(" ");//sets an empty string if user didn't input anything
                                break;
                        }
                        if (!key.equals("unid"))
                            viewEntry.entryData.put(key, ed);
                    }

                    sqLiteDatabase = dbHandler.getWritableDatabase();
                    if (extras != null) {//user is trying to update an entry
                        dbHandler.updateViewEntry(viewEntry, sqLiteDatabase);
                        Toast.makeText(getApplicationContext(), "Your event has been updated", Toast.LENGTH_LONG).show();
                    } else {//user is trying to create an entry
                        dbHandler.addViewEntry(viewEntry, sqLiteDatabase);
                        Toast.makeText(getApplicationContext(), "Your event has been created", Toast.LENGTH_LONG).show();
                    }
                    Intent intent = new Intent(Add_Edit_EventForm.this, MyEvents.class);
                    startActivity(intent);

                } catch (final Exception ex) {
                    //Log.i("addEntry", "Exception in thread");
                }
            }
        });
    }

    //on Restart - used to make sure the aappropriatetheme is set
    @Override
    protected void onRestart() {
        super.onRestart();
        finish();
        startActivity(getIntent());
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_add_event_form, menu);
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
            Intent intent = new Intent(Add_Edit_EventForm.this, Settings.class);
            startActivity(intent);
            return true;
        } else if (id == R.id.actionbar_help) {
            Intent intent = new Intent(Add_Edit_EventForm.this, Help.class);
            startActivity(intent);
        }

        return super.onOptionsItemSelected(item);
    }
}
