package vm.eventtracker.DatabaseClasses;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;
import android.widget.Toast;

import vm.eventtracker.Parser_Classes.ViewEntry;

//code inspired by: https://www.youtube.com/watch?v=38DOncHIazs and https://www.youtube.com/watch?v=ahE8bQRD4f0
//Class that uses the SQLiteOpenHelper to access, store and find database items
public class EventDBHandler extends SQLiteOpenHelper {

    private static final int DATABASE_VERSION = 1;
    private static String DATABASE_NAME = "EventsFestivals.db";
    private static String CREATE_QUERY =
            "CREATE TABLE " + DBClassValues.TrackEvent.TABLE_NAME + "(" +
                    DBClassValues.TrackEvent.UNID + " TEXT PRIMARY KEY," +
                    DBClassValues.TrackEvent.EVENT_NAME + " TEXT," +
                    DBClassValues.TrackEvent.BEGIN_SHOW + " TEXT," +
                    DBClassValues.TrackEvent.CATEGORY + " TEXT," +
                    DBClassValues.TrackEvent.ORG_NAME + " TEXT," +
                    DBClassValues.TrackEvent.TIME_BEGIN + " TEXT," +
                    DBClassValues.TrackEvent.END_SHOW + " TEXT," +
                    DBClassValues.TrackEvent.TIME_END + " TEXT," +
                    DBClassValues.TrackEvent.LONG_DESC + " TEXT," +
                    DBClassValues.TrackEvent.ORG_PHONE + " TEXT," +
                    DBClassValues.TrackEvent.ORG_PHONEEXT + " TEXT," +
                    DBClassValues.TrackEvent.ORG_EMAIL + " TEXT," +
                    DBClassValues.TrackEvent.LOCATION + " TEXT," +
                    DBClassValues.TrackEvent.INTERSECTION + " TEXT," +
                    DBClassValues.TrackEvent.MAPLINK + " TEXT," +
                    DBClassValues.TrackEvent.TTC + " TEXT," +
                    DBClassValues.TrackEvent.EVENT_LINK + " TEXT," +
                    DBClassValues.TrackEvent.PERFORMANCE + " TEXT," +
                    DBClassValues.TrackEvent.ADDRESS + " TEXT," +
                    DBClassValues.TrackEvent.TYPE + " TEXT);";


    //Constructor that will be called when EventDBHandler is used and will  either open the database or create it for the first time
    public EventDBHandler(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
        //  Log.e("Database Operations:", "Database created / opened");
    }

    /*If the app does not currently contain the required table ('TrackEvent') then it will create it
    using the an SQL query to create the table and it's columns    */
    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL(CREATE_QUERY);
        //  Log.e("Database Operations:", "Table created");

    }

    //Called when an existing Event is trying to be updated. This function will update the specific event in the database
    public void updateViewEntry(ViewEntry Ventry, SQLiteDatabase db) {
        ContentValues values = new ContentValues();
        values = DBClassValues.getValues(Ventry, values);//function that will return all updated values for the DB query

        db.update(DBClassValues.TrackEvent.TABLE_NAME, values, "unid = ?", new String[]{Ventry.unid});
        //   Log.e("Database Operations:", "row updated");
        db.close();

    }

    /*Function is called when an Event is trying to be added to the database. This function will attempt to add the View Entry to the database,
      if a duplicate entry is found it will not add the entry to the database */
    public void addViewEntry(ViewEntry Ventry, SQLiteDatabase db) {
        String query = "SELECT * FROM " + DBClassValues.TrackEvent.TABLE_NAME + " Where unid = ?";

        Cursor cur = db.rawQuery(query, new String[]{Ventry.unid});
        if (cur.getCount() == 0) {
            ContentValues values = new ContentValues();
            values = DBClassValues.getValues(Ventry, values);//function that will return all updated values for the DB query

            db.insert(DBClassValues.TrackEvent.TABLE_NAME, null, values);
            // Log.e("Database Operations:", "1 row inserted");
            db.close();
        } else {
            db.close();
            //  Log.e("Database Operation:", "duplicate entry found");
        }
    }

    //code copied from: https://stackoverflow.com/questions/7510219/deleting-row-in-sqlite-in-android
    //Will attempt to delete the specified event from the database. Returns true if successful, false if not
    public Boolean DeleteViewEntry(String uuid, SQLiteDatabase db) {
        // Log.e("Database Operations:", uuid + "row deleted");
        return db.delete(DBClassValues.TrackEvent.TABLE_NAME, "unid = ?", new String[]{uuid}) > 0;
    }

    //This function returns a cursor that will be used in activities to all retrieve items from the database
    public Cursor getViewEntryCursor(SQLiteDatabase db) {
        Cursor cursor;
        String[] projections = {
                DBClassValues.TrackEvent.UNID,
                DBClassValues.TrackEvent.EVENT_NAME,
                DBClassValues.TrackEvent.BEGIN_SHOW,
                DBClassValues.TrackEvent.CATEGORY,
                DBClassValues.TrackEvent.ORG_NAME,
                DBClassValues.TrackEvent.TIME_BEGIN,
                DBClassValues.TrackEvent.END_SHOW,
                DBClassValues.TrackEvent.TIME_END,
                DBClassValues.TrackEvent.LONG_DESC,
                DBClassValues.TrackEvent.ORG_PHONE,
                DBClassValues.TrackEvent.ORG_PHONEEXT,
                DBClassValues.TrackEvent.ORG_EMAIL,
                DBClassValues.TrackEvent.LOCATION,
                DBClassValues.TrackEvent.INTERSECTION,
                DBClassValues.TrackEvent.MAPLINK,
                DBClassValues.TrackEvent.TTC,
                DBClassValues.TrackEvent.EVENT_LINK,
                DBClassValues.TrackEvent.PERFORMANCE,
                DBClassValues.TrackEvent.ADDRESS,
                DBClassValues.TrackEvent.TYPE
        };

        cursor = db.query(DBClassValues.TrackEvent.TABLE_NAME, projections, null, null, null, null, null);
        return cursor;
    }

    //Would be used to update the database version
    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {

    }


}
