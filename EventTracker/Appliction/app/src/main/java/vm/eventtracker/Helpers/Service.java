package vm.eventtracker.Helpers;

import android.app.IntentService;
import android.content.Intent;
import android.support.v4.content.LocalBroadcastManager;
import android.util.Log;

//code copied from: https://developer.android.com/training/run-background-service/create-service.html and https://groups.google.com/forum/#!topic/android-developers/HVBnJ15amVc
public class Service extends IntentService {

    public Service() {
        super("Service");
    }

    //Worker thread that will be used to send broadcasts through a specific intent name
    @Override
    protected void onHandleIntent(Intent intent) {
        Intent broadcast = new Intent("eventTracker.notification.myEvents");

        LocalBroadcastManager.getInstance(this).sendBroadcast(broadcast);
        // Log.d("Service", "Done sending broadcast");
    }

}
