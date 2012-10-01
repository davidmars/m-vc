var UtilsTime={
    /**
     * Jours de la semaine en français, Dimanche, lundi...
     */
    dayNames_fr: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    /**
     * Jours de la semaine en français, Di, Lu...
     */
    dayNamesMin_fr: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
     /**
     * Mois en français, Janvier, Février...
     */
    monthNames_fr: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
    /**
     * retourne un objet contenant les valeurs h pour les heures, m pour les minutes,s pour les secondes
     */
    MStoHMS:function(ms)
    {
        H = Math.floor(ms / (1000*60*60));
        M = (ms % (1000*60*60)) / (1000*60);
        S = ((ms % (1000*60*60)) % (1000*60)) / 1000;
        return {h:H,m:M,s:S}
    },
    // format a Date object to yyyy/m/d
    date2yyyymmdd:function(dt)
    {
        var m = dt.getMonth() + 1;
        var d = dt.getDate();
        return dt.getFullYear() + '-' + ((m<10) ? '0':'') + m + '-' + ((d<10) ? '0':'') + d;
    }
}

