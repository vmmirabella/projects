package vm.eventtracker.Parser_Classes;
import java.util.HashMap;

//class used to store an Event object, structured similar to website data (viewentry and entrydata)
public class ViewEntry {
    public String unid;
    public HashMap<String, EntryData> entryData;

    public ViewEntry() {
        entryData = new HashMap<>(30);
    }

    public EntryData getEDByName(String name) {
        return entryData.get(name);
    }

    public static class EntryData {
        private String name;
        private String text;

        public String getName() {
            return name;
        }

        public void setName(String name) {
            this.name = name;
        }

        public String getText() {
            return text;
        }

        public void setText(String text) {
            this.text = text;
        }

        public EntryData() {
        }
    }
}