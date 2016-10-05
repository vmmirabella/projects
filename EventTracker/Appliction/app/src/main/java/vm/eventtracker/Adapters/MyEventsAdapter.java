package vm.eventtracker.Adapters;

import android.content.Context;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

import vm.eventtracker.R;
import vm.eventtracker.Parser_Classes.ViewEntry;

//code for this class inspired from: https://www.youtube.com/watch?v=V4FqE83K1n0
public class MyEventsAdapter extends ArrayAdapter {
    private String themePreference;

    List<ViewEntry> list = new ArrayList<ViewEntry>();

    //Constructor takes in context, layout (that will be used) and theme preference to be used on list items
    public MyEventsAdapter(Context context, int resource, String pref) {
        super(context, resource);
        themePreference = pref;

    }

    static class LayoutHandler {
        TextView EventName, BeginShow, Address, Type, EventHeader, BeginHeader, AddressHeader;
    }

    //Adds a viewEntry object to a list of viewEntries that will be displayed with getView()
    @Override
    public void add(Object viewEntry) {
        super.add(viewEntry);
        list.add((ViewEntry) viewEntry);
    }

    //Returns the size of list (list of ViewEntry objects)
    @Override
    public int getCount() {
        return list.size();
    }

    //Returns the specific ViewEntry object being referenced in it's parameter
    @Override
    public Object getItem(int position) {
        return list.get(position);
    }

    //Returns a view based on the passed in ViewEntry object and displays it's Event Name, Address, and start Date.
    //Each view will also have their text color updated based on which theme the user has selected
    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        View row = convertView;
        LayoutHandler layoutHandler = new LayoutHandler();

        if (row == null) {

            LayoutInflater inflater = (LayoutInflater) this.getContext().getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            row = inflater.inflate(R.layout.listview_layout, parent, false);

            layoutHandler.EventName = (TextView) row.findViewById(R.id.EventNameList);
            layoutHandler.BeginShow = (TextView) row.findViewById(R.id.BeginShowList);
            layoutHandler.Address = (TextView) row.findViewById(R.id.AddressList);
            layoutHandler.Type = (TextView) row.findViewById(R.id.Type);

            row.setTag(layoutHandler);
        } else {
            layoutHandler = (LayoutHandler) row.getTag();
        }

        ViewEntry viewEntry = (ViewEntry) this.getItem(position);

        //Adds text to the right right of the list to signify if the event was created or added to be tracked
        if (viewEntry.getEDByName("Type").getText().equals("Created"))
            layoutHandler.Type.setText("Your Event");
        else
            layoutHandler.Type.setText("Event/Festival");

        //Sets text for each TextView with the values from the ViewEntry object
        layoutHandler.EventName.setText(viewEntry.getEDByName("EventName").getText());
        layoutHandler.BeginShow.setText(viewEntry.getEDByName("DateBeginShow").getText());
        layoutHandler.Address.setText(viewEntry.getEDByName("Address").getText());

        int color;
        if (themePreference.equals("ThemeDark"))//change text color based on theme chosen by user
            color = Color.WHITE;
        else
            color = Color.BLACK;

        //Header textviews
        layoutHandler.BeginHeader = (TextView) row.findViewById(R.id.list_BeginShowHeader);
        layoutHandler.EventHeader = (TextView) row.findViewById(R.id.list_EventNameHeader);
        layoutHandler.AddressHeader = (TextView) row.findViewById(R.id.list_AddressHeader);

        //Apply color text based on theme for each textview
        layoutHandler.EventHeader.setTextColor(color);
        layoutHandler.AddressHeader.setTextColor(color);
        layoutHandler.BeginHeader.setTextColor(color);
        layoutHandler.EventName.setTextColor(color);
        layoutHandler.BeginShow.setTextColor(color);
        layoutHandler.Address.setTextColor(color);
        layoutHandler.Type.setTextColor(color);


        return row;
    }


}
