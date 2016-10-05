package vm.eventtracker.Helpers;

import java.text.DateFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Comparator;

import vm.eventtracker.Parser_Classes.ViewEntry;

//Used to sort ViewEntry objects in ascending order
public class DateComparator implements Comparator<ViewEntry> {

    private static final DateFormat format = new SimpleDateFormat("MMM d, yyyy");

    //Compares both strings
    public int compare(ViewEntry a, ViewEntry b) {

        String dateA = a.getEDByName("DateBeginShow").getText();
        String dateB = b.getEDByName("DateBeginShow").getText();

        return compareDates(dateA, dateB);
    }

    /*code to parse and compare from: http://stackoverflow.com/questions/14451976/how-to-sort-date-which-is-in-string-format-in-java
        Used to compare specifically formatted strings that contain dates (ie. Nov 13, 2015).
        Returns 0 if the first string is equal, -1 if less than and 1 if greater than the second string    */
    private int compareDates(String o1, String o2) {
        try {
            return format.parse(o1).compareTo(format.parse(o2));
        } catch (ParseException e) {
            throw new IllegalArgumentException(e);
        }
    }
}

