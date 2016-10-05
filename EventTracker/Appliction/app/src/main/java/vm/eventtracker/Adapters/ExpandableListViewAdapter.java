package vm.eventtracker.Adapters;

import android.content.Context;
import android.graphics.Color;
import android.widget.BaseExpandableListAdapter;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import java.util.HashMap;
import java.util.List;

import vm.eventtracker.R;
import vm.eventtracker.Parser_Classes.ViewEntry;

//Most of code (such as what functions were needed and some content in them)copied/inspired from:
// http://inducesmile.com/android-tutorials-for-nigerian-developer/android-expandable-listview-example-tutorial/
public class ExpandableListViewAdapter extends BaseExpandableListAdapter {
    private Context context;
    private List<String> parentDataSource;
    private HashMap<String, List<ViewEntry>> childDataSource;
    private String themePreference;

    //Constructor that takes in the context, list of parents, list of associated children and theme preference chosen; sets private fields
    public ExpandableListViewAdapter(Context context, List<String> childParent, HashMap<String, List<ViewEntry>> child, String theme) {
        this.context = context;
        this.parentDataSource = childParent;
        this.childDataSource = child;
        themePreference = theme;
    }

    //Returns how many groups/parents have been passed into this adapter
    @Override
    public int getGroupCount() {
        return this.parentDataSource.size();
    }

    //Returns the number of children for the specified parent
    @Override
    public int getChildrenCount(int groupPosition) {
        return this.childDataSource.get(this.parentDataSource.get(groupPosition)).size();
    }

    //Returns the group/parent by it's position in the list
    @Override
    public Object getGroup(int groupPosition) {
        return parentDataSource.get(groupPosition);
    }

    //Returns a child (ViewEntry object) based on the parent and where the child is located within that parent's list
    @Override
    public Object getChild(int groupPosition, int childPosition) {
        return this.childDataSource.get(parentDataSource.get(groupPosition)).get(childPosition);
    }

    //Returns an ID for a group at the given position in the list
    @Override
    public long getGroupId(int groupPosition) {
        return groupPosition;
    }

    //Returns an ID for a child within a group at the given positions
    @Override
    public long getChildId(int groupPosition, int childPosition) {
        return childPosition;
    }

    //If an item is updated via notifyDataSetChanged() it will only update affected items rather than the whole list again
    @Override
    public boolean hasStableIds() {
        return false;
    }

    //Returns a parents/groups names and displays it in a view. Each parent is an expandable list
    //themePreference is used to change to the appropriate text color because views that use custom adapters don't change through setting theme only
    @Override
    public View getGroupView(int groupPosition, boolean isExpanded, View convertView, ViewGroup parent) {
        View view = convertView;
        if (view == null) {
            LayoutInflater inflater = (LayoutInflater) this.context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            view = inflater.inflate(R.layout.parent_layout, parent, false);
        }
        String parentHeader = (String) getGroup(groupPosition);
        TextView parentItem = (TextView) view.findViewById(R.id.parent_layout);
        parentItem.setText(parentHeader);

        //setTheme wouldn't work for customer adapter, so manually setting textcolor based on theme from SharedPreferences
        if (themePreference.equals("ThemeDark"))
            parentItem.setTextColor(Color.WHITE);
        else
            parentItem.setTextColor(Color.BLACK);

        return view;
    }


    //Returns a view for a child of a specific parent/group
    //themePreference is used to change to the appropriate text color to match the theme chosen by the user or the default one
    @Override
    public View getChildView(int groupPosition, int childPosition, boolean isLastChild, View convertView, ViewGroup parent) {
        View view = convertView;

        TextView childEventName, childBeginShow, childAddress, childCategory;

        LayoutInflater inflater = (LayoutInflater) this.context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        view = inflater.inflate(R.layout.child_layout, parent, false);

        //Creates a ViewEntry object based parent and the child's position within it
        ViewEntry child = (ViewEntry) getChild(groupPosition, childPosition);

        childEventName = (TextView) view.findViewById(R.id.child_EventName);
        childBeginShow = (TextView) view.findViewById(R.id.child_BeginShow);
        childAddress = (TextView) view.findViewById(R.id.child_Address);
        childCategory = (TextView) view.findViewById(R.id.child_Category);

        //Sets the text for each view
        childEventName.setText(child.getEDByName("EventName").getText());
        childBeginShow.setText(child.getEDByName("DateBeginShow").getText());
        childAddress.setText(child.getEDByName("Address").getText());
        childCategory.setText(child.getEDByName("CategoryList").getText());

        TextView childEventHeader = (TextView) view.findViewById(R.id.child_EventNameHeader);
        TextView childBeginHeader = (TextView) view.findViewById(R.id.child_BeginShowHeader);
        TextView childAddressHeader = (TextView) view.findViewById(R.id.child_AddressHeader);
        TextView childCatHeader = (TextView) view.findViewById(R.id.child_CategoryHeader);

        //Sets the color based on the theme stored in shared preferences
        int color;
        if (themePreference.equals("ThemeDark"))
            color = Color.WHITE;
        else
            color = Color.BLACK;

        childEventHeader.setTextColor(color);
        childBeginHeader.setTextColor(color);
        childAddressHeader.setTextColor(color);
        childCatHeader.setTextColor(color);
        childEventName.setTextColor(color);
        childBeginShow.setTextColor(color);
        childAddress.setTextColor(color);
        childCategory.setTextColor(color);

        return view;
    }


    //Whether a child within a parent is selectable
    @Override
    public boolean isChildSelectable(int groupPosition, int childPosition) {
        return true;
    }
}