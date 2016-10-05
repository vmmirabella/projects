package vm.eventtracker.Parser_Classes;


import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

import java.io.IOException;
import java.io.InputStream;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

import javax.xml.parsers.ParserConfigurationException;
import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;

//inspiration for this class from: http://examples.javacodegeeks.com/core-java/xml/sax/get-element-attributes-in-sax-xml-parsing
//Uses a SAX parser to parse the linked website and create ViewEntry objects
public class LiveFeedParser extends DefaultHandler {
    private boolean isText, isTextList;
    private List<ViewEntry> viewEntries;
    private int i;
    private ViewEntry.EntryData ed;
    private String URL_MAIN = "http://wx.toronto.ca/festevents.nsf/tpaview?readviewentries";
    static private final String[] whiteList = new String[]{
            "unid", "EventName", "DateBeginShow", "CategoryList", "PresentedByOrgName", "TimeBegin", "DateEndShow",
            "TimeEnd", "LongDesc", "OrgContactPhone", "OrgContactExt", "OrgContactEMail", "Location", "Intersection", "MapAddress",
            "TTC", "EventURL", "Performance", "Address"
    };

    //starts the SAX parser, opens the website to be parsed, initializes viewEntries list.
    public void get() {
        try {
            SAXParserFactory factory = SAXParserFactory.newInstance();
            SAXParser saxParser = factory.newSAXParser();

            LiveFeedParser handler = new LiveFeedParser(999);
            InputStream mInputStream = new URL(URL_MAIN).openStream();
            saxParser.parse(mInputStream, handler);
            viewEntries = handler.getViewEntries();

        } catch (ParserConfigurationException e) {
            e.printStackTrace();
        } catch (SAXException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }

    //constructor that sets the initial size of viewEntries
    public LiveFeedParser(int size) {
        clear(size);
    }

    //clears LiveFeedParser and sets everything back to it's default state
    public void clear(int size) {
        i = 0;
        isTextList = false;
        isText = false;
        viewEntries = new ArrayList<>(size);
        ed = null;
    }


    //returns viewEntries object, used after parse has completed
    public List<ViewEntry> getViewEntries() {
        return viewEntries;
    }

    //function used when the parser reaches a start tag/element
    @Override
    public void startElement(String uri, String localName, String qName,
                             Attributes attributes) throws SAXException {

        switch (qName) {
            case "viewentry":
                viewEntries.add(new ViewEntry());
                break;
            case "textlist":
                isTextList = true;
                break;
            case "text":
                isText = true;
                break;
            case "entrydata":
                ed = new ViewEntry.EntryData();
                break;
        }

        int length = attributes.getLength();


        // process each attribute
        for (int j = 0; j < length; j++) {

            // get qualified (prefixed) name by index
            String name = attributes.getQName(j);

            // get attribute's value by index.
            String value = attributes.getValue(j);

            //Handle ViewEntry Attributes
            if (name.equals("unid"))
                viewEntries.get(i).unid = value;

            //Handle EntryData Attributes
            if (name.equals("name")) {
                ed.setName(value);
            }
        }
    }

    //function makes sure thatonly select certain EntryData criteria (used to select relevant data) will be added to viewEntries
    private boolean isWhiteListed(String s) {
        if (s == null)
            return false;

        for (String n : whiteList) {
            if (n.equals(s)) {
                return true;
            }
        }
        return false;
    }

    //called when a pair of matching tags/elements are found, denoting end of that data
    @Override
    public void endElement(String uri, String localName,
                           String qName) throws SAXException {

        if (qName.equals("viewentry")) {
            i++;
        } else if (qName.equals("textlist")) {
            isTextList = false;
        } else if (qName.equals("text")) {
            isText = false;
        } else if (qName.equals("entrydata") && isWhiteListed(ed.getName())) {
            viewEntries.get(i).entryData.put(ed.getName(), ed);
            ed = null;
        }


    }

    //used to extract data(as Strings) from the text tags within each EntryData
    @Override
    public void characters(char ch[], int start, int length) throws SAXException {

        //if there is a textlist and there is text and the tag is whitelisted
        if ((isText || isTextList) && isWhiteListed(ed.getName())) {
            String str = new String(ch, start, length);
            //concatenates sets of strings (sometimes it would stop at characters such as: ";" "'" ",")
            //else if and else statements are to get around this problem
            if (ed.getText() == null)
                ed.setText(str);
            else if (ed.getName().equals("LongDesc")) {
                String temp = ed.getText();
                temp += ". " + str;
                ed.setText(temp);
            } else {
                String temp = ed.getText();
                temp += str;
                ed.setText(temp);
            }
        }
    }

}

