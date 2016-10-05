package vm.eventtracker.DatabaseClasses;

import android.content.ContentValues;

import vm.eventtracker.Parser_Classes.ViewEntry;

//code inspired by: https://www.youtube.com/watch?v=38DOncHIazs
//Class that contains all the DB values(column names) and table name
public class DBClassValues {

    public static abstract class TrackEvent {
        public static final String UNID = "unid";
        public static final String EVENT_NAME = "EventName";
        public static final String BEGIN_SHOW = "DateBeginShow";
        public static final String CATEGORY = "CategoryList";
        public static final String ORG_NAME = "PresentedByOrgName";
        public static final String TIME_BEGIN = "TimeBegin";
        public static final String END_SHOW = "DateEndShow";
        public static final String TIME_END = "TimeEnd";
        public static final String LONG_DESC = "LongDesc";
        public static final String ORG_PHONE = "OrgContactPhone";
        public static final String ORG_PHONEEXT = "OrgContactExt";
        public static final String ORG_EMAIL = "OrgContactEMail";
        public static final String LOCATION = "Location";
        public static final String INTERSECTION = "Intersection";
        public static final String MAPLINK = "MapAddress";
        public static final String TTC = "TTC";
        public static final String EVENT_LINK = "EventURL";
        public static final String PERFORMANCE = "Performance";
        public static final String ADDRESS = "Address";
        public static final String TYPE = "Type";
        public static final String TABLE_NAME = "TrackEvent";


    }

    //Returns an updated ContentValues containing all updated columns to be used in DB query
    public static ContentValues getValues(ViewEntry Ventry,  ContentValues values)
    {
        values.put(TrackEvent.UNID, Ventry.unid);
        values.put(TrackEvent.EVENT_NAME, Ventry.getEDByName("EventName").getText());
        values.put(TrackEvent.BEGIN_SHOW, Ventry.getEDByName("DateBeginShow").getText());
        values.put(TrackEvent.CATEGORY, Ventry.getEDByName("CategoryList").getText());
        values.put(TrackEvent.ORG_NAME, Ventry.getEDByName("PresentedByOrgName").getText());
        values.put(TrackEvent.TIME_BEGIN, Ventry.getEDByName("TimeBegin").getText());
        values.put(TrackEvent.END_SHOW, Ventry.getEDByName("DateEndShow").getText());
        values.put(TrackEvent.TIME_END, Ventry.getEDByName("TimeEnd").getText());
        values.put(TrackEvent.LONG_DESC, Ventry.getEDByName("LongDesc").getText());
        values.put(TrackEvent.ORG_PHONE, Ventry.getEDByName("OrgContactPhone").getText());
        values.put(TrackEvent.ORG_PHONEEXT, Ventry.getEDByName("OrgContactExt").getText());
        values.put(TrackEvent.ORG_EMAIL, Ventry.getEDByName("OrgContactEMail").getText());
        values.put(TrackEvent.LOCATION, Ventry.getEDByName("Location").getText());
        values.put(TrackEvent.INTERSECTION, Ventry.getEDByName("Intersection").getText());
        values.put(TrackEvent.MAPLINK, Ventry.getEDByName("MapAddress").getText());
        values.put(TrackEvent.TTC, Ventry.getEDByName("TTC").getText());
        values.put(TrackEvent.EVENT_LINK, Ventry.getEDByName("EventURL").getText());
        values.put(TrackEvent.PERFORMANCE, Ventry.getEDByName("Performance").getText());
        values.put(TrackEvent.ADDRESS, Ventry.getEDByName("Address").getText());
        values.put(TrackEvent.TYPE, Ventry.getEDByName("Type").getText());

        return values;
    }
}
